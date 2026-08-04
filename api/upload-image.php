<?php
/**
 * Upload image for blog featured image (or other use).
 * POST multipart/form-data with field "image".
 * Returns JSON: { "success": true, "url": "uploads/blog/xxx.jpg" }
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$field = 'image';
if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
    $err = isset($_FILES[$field]['error']) ? $_FILES[$field]['error'] : 'no file';
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Upload failed: ' . $err]);
    exit;
}

$file = $_FILES[$field];
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);
if (!in_array($mime, $allowed, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Use JPEG, PNG, GIF, or WebP.']);
    exit;
}

$ext = [
    'image/jpeg' => '.jpg',
    'image/png'  => '.png',
    'image/gif'  => '.gif',
    'image/webp' => '.webp',
][$mime];

$uploadDir = __DIR__ . '/../uploads/blog';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$name = 'img_' . time() . '_' . substr(bin2hex(random_bytes(4)), 0, 8) . $ext;
$path = $uploadDir . '/' . $name;

if (!move_uploaded_file($file['tmp_name'], $path)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    exit;
}

$url = '/uploads/blog/' . $name;
echo json_encode(['success' => true, 'url' => $url]);
