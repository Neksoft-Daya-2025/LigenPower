<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$usersFile = __DIR__ . '/../config/dealer-users.json';
$productsFile = __DIR__ . '/../config/products.json';
$bookingsFile = __DIR__ . '/../config/prebookings.json';

function dealerReply($success, $message = '', $extra = [], $status = 200) {
    http_response_code($status);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra), JSON_UNESCAPED_SLASHES);
    exit;
}

function dealerText($value, $max = 500) {
    $value = trim((string)$value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

function loadJsonList($file, $key) {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) && isset($data[$key]) && is_array($data[$key]) ? $data[$key] : [];
}

function saveJsonList($file, $key, $items) {
    $dir = dirname($file);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    return file_put_contents($file, json_encode([$key => array_values($items), 'updated_at' => date('c')], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}

function publicProducts($productsFile) {
    $items = loadJsonList($productsFile, 'products');
    $items = array_values(array_filter($items, function($item) {
        return !isset($item['active']) || $item['active'];
    }));
    usort($items, function($a, $b) { return strcmp($a['name'] ?? '', $b['name'] ?? ''); });
    return $items;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'products') dealerReply(true, '', ['products' => publicProducts($productsFile)]);
    if ($action === 'bookings') {
        $bookings = loadJsonList($bookingsFile, 'bookings');
        usort($bookings, function($a, $b) { return strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''); });
        dealerReply(true, '', ['bookings' => $bookings]);
    }
    dealerReply(false, 'Unknown action.', [], 400);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) dealerReply(false, 'Invalid request.', [], 400);

    if ($action === 'login') {
        $email = strtolower(dealerText($data['email'] ?? '', 180));
        $password = (string)($data['password'] ?? '');
        foreach (loadJsonList($usersFile, 'users') as $user) {
            $hash = $user['password_hash'] ?? '';
            $legacyPassword = $user['password'] ?? null;
            $passwordMatches = $hash ? password_verify($password, $hash) : ($legacyPassword !== null && $legacyPassword === $password);
            if (strtolower($user['email'] ?? '') === $email && $passwordMatches && !empty($user['active'])) {
                unset($user['password']);
                unset($user['password_hash']);
                dealerReply(true, 'Login successful.', ['user' => $user]);
            }
        }
        dealerReply(false, 'Invalid login details.', [], 401);
    }

    if ($action === 'prebook') {
        $productId = dealerText($data['product_id'] ?? '', 100);
        $dealerName = dealerText($data['dealer_name'] ?? '', 180);
        $dealerEmail = strtolower(dealerText($data['dealer_email'] ?? '', 180));
        $company = dealerText($data['company'] ?? '', 180);
        $quantity = max(1, (int)($data['quantity'] ?? 0));
        $note = dealerText($data['note'] ?? '', 1000);

        if ($productId === '') dealerReply(false, 'Please select a product.', [], 422);
        if ($dealerName === '') dealerReply(false, 'Dealer name is required.', [], 422);
        if (!filter_var($dealerEmail, FILTER_VALIDATE_EMAIL)) dealerReply(false, 'Valid email is required.', [], 422);

        $product = null;
        foreach (publicProducts($productsFile) as $item) {
            if (($item['id'] ?? '') === $productId) { $product = $item; break; }
        }
        if (!$product) dealerReply(false, 'Product not found.', [], 404);
        if ($quantity > (int)($product['stock'] ?? 0)) dealerReply(false, 'Requested quantity is higher than available stock.', [], 422);

        $bookings = loadJsonList($bookingsFile, 'bookings');
        $booking = [
            'id' => 'prebook-' . time() . '-' . bin2hex(random_bytes(3)),
            'product_id' => $productId,
            'product_name' => $product['name'] ?? '',
            'sku' => $product['sku'] ?? '',
            'quantity' => $quantity,
            'dealer_name' => $dealerName,
            'dealer_email' => $dealerEmail,
            'company' => $company,
            'note' => $note,
            'status' => 'Pending',
            'created_at' => date('c')
        ];
        $bookings[] = $booking;
        if (!saveJsonList($bookingsFile, 'bookings', $bookings)) dealerReply(false, 'Could not save pre-booking.', [], 500);
        dealerReply(true, 'Pre-booking request submitted.', ['booking' => $booking]);
    }

    dealerReply(false, 'Unknown action.', [], 400);
}

dealerReply(false, 'Method not allowed.', [], 405);
