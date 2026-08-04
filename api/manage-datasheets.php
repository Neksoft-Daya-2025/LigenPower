<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$configDir = __DIR__ . '/../config';
$configFile = $configDir . '/datasheets.json';
$uploadDir = __DIR__ . '/../uploads/datasheets';

function respond($success, $message = '', $extra = [], $status = 200) {
    http_response_code($status);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra), JSON_UNESCAPED_SLASHES);
    exit;
}

function loadDatasheets($file) {
    if (!file_exists($file)) return [];
    $decoded = json_decode(file_get_contents($file), true);
    return is_array($decoded) && isset($decoded['datasheets']) && is_array($decoded['datasheets']) ? $decoded['datasheets'] : [];
}

function saveDatasheets($file, $items) {
    $dir = dirname($file);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    $payload = ['datasheets' => array_values($items), 'updated_at' => date('c')];
    return file_put_contents($file, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}

function cleanText($value, $max = 180) {
    $value = trim((string)$value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

$method = $_SERVER['REQUEST_METHOD'];
$items = loadDatasheets($configFile);

if ($method === 'GET') {
    $admin = isset($_GET['admin']) && $_GET['admin'] === '1';
    if (!$admin) $items = array_values(array_filter($items, function ($item) { return !empty($item['published']); }));
    usort($items, function ($a, $b) { return strcmp($b['updated_at'] ?? '', $a['updated_at'] ?? ''); });
    respond(true, '', ['datasheets' => $items]);
}

if ($method === 'POST') {
    $id = cleanText($_POST['id'] ?? '', 80);
    $title = cleanText($_POST['title'] ?? '');
    $category = cleanText($_POST['category'] ?? 'Other');
    $description = cleanText($_POST['description'] ?? '', 500);
    $image = cleanText($_POST['image'] ?? '', 500);
    $published = ($_POST['published'] ?? '1') === '1';
    if ($title === '') respond(false, 'Datasheet title is required.', [], 422);

    $index = -1;
    foreach ($items as $i => $item) if (($item['id'] ?? '') === $id && $id !== '') { $index = $i; break; }
    $existing = $index >= 0 ? $items[$index] : null;
    $pdfUrl = $existing['pdf_url'] ?? '';
    $originalName = $existing['file_name'] ?? '';

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['pdf'];
        if ($file['error'] !== UPLOAD_ERR_OK) respond(false, 'PDF upload failed (code ' . $file['error'] . ').', [], 400);
        if ($file['size'] > 15 * 1024 * 1024) respond(false, 'PDF must be 15 MB or smaller.', [], 413);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if ($mime !== 'application/pdf') respond(false, 'Only valid PDF files are allowed.', [], 415);
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) respond(false, 'Could not create upload directory.', [], 500);
        $safeBase = strtolower(preg_replace('/[^a-z0-9]+/i', '-', pathinfo($file['name'], PATHINFO_FILENAME)));
        $safeBase = trim($safeBase, '-') ?: 'datasheet';
        $storedName = $safeBase . '-' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.pdf';
        if (!move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $storedName)) respond(false, 'Could not save uploaded PDF.', [], 500);
        if ($existing && !empty($existing['pdf_url'])) {
            $old = basename($existing['pdf_url']);
            if (preg_match('/\.pdf$/i', $old) && file_exists($uploadDir . '/' . $old)) @unlink($uploadDir . '/' . $old);
        }
        $pdfUrl = 'uploads/datasheets/' . $storedName;
        $originalName = basename($file['name']);
    }
    if ($pdfUrl === '') respond(false, 'Please select a PDF datasheet.', [], 422);

    $now = date('c');
    $record = ['id' => $existing['id'] ?? ('ds-' . time() . '-' . bin2hex(random_bytes(3))), 'title' => $title,
        'category' => $category, 'description' => $description, 'image' => $image, 'pdf_url' => $pdfUrl,
        'file_name' => $originalName, 'published' => $published, 'created_at' => $existing['created_at'] ?? $now, 'updated_at' => $now];
    if ($index >= 0) $items[$index] = $record; else $items[] = $record;
    if (!saveDatasheets($configFile, $items)) respond(false, 'Could not save datasheet catalogue.', [], 500);
    respond(true, $index >= 0 ? 'Datasheet updated.' : 'Datasheet uploaded.', ['datasheet' => $record]);
}

if ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = cleanText($input['id'] ?? '', 80);
    if ($id === '') respond(false, 'Datasheet ID is required.', [], 422);
    $deleted = null;
    $remaining = [];
    foreach ($items as $item) { if (($item['id'] ?? '') === $id) $deleted = $item; else $remaining[] = $item; }
    if (!$deleted) respond(false, 'Datasheet not found.', [], 404);
    if (!saveDatasheets($configFile, $remaining)) respond(false, 'Could not update datasheet catalogue.', [], 500);
    $file = basename($deleted['pdf_url'] ?? '');
    if (preg_match('/\.pdf$/i', $file) && file_exists($uploadDir . '/' . $file)) @unlink($uploadDir . '/' . $file);
    respond(true, 'Datasheet deleted.');
}

respond(false, 'Method not allowed.', [], 405);
