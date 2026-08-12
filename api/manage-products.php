<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$file = __DIR__ . '/../config/products.json';

function productReply($success, $message = '', $extra = [], $status = 200) {
    http_response_code($status);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra), JSON_UNESCAPED_SLASHES);
    exit;
}

function productText($value, $max = 500) {
    $value = trim((string)$value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

function defaultProducts() {
    return [[
        'id' => 'lfp-battery-1',
        'name' => 'Ligen 12V 100Ah LFP Battery',
        'price' => 35000,
        'image' => 'assets/images/product/pb1.jpg',
        'url' => '12v-100ah-lfp-battery',
        'description' => 'Long-life LFP battery with advanced BMS protection.',
        'stock' => 10,
        'category' => 'LFP Batteries',
        'subcategory' => '12V Battery',
        'sku' => 'LP-LFP-12V100',
        'active' => true,
        'updated_at' => date('c')
    ]];
}

function productLoad($file) {
    if (!file_exists($file)) return defaultProducts();
    $data = json_decode(file_get_contents($file), true);
    if (is_array($data) && isset($data['products']) && is_array($data['products'])) return $data['products'];
    return defaultProducts();
}

function productSave($file, $items) {
    $dir = dirname($file);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    return file_put_contents($file, json_encode(['products' => array_values($items), 'updated_at' => date('c')], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}

$items = productLoad($file);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $admin = isset($_GET['admin']) && $_GET['admin'] === '1';
    if (!$admin) {
        $items = array_values(array_filter($items, function($item) {
            return !isset($item['active']) || $item['active'];
        }));
    }
    usort($items, function($a, $b) {
        return strcmp($a['name'] ?? '', $b['name'] ?? '');
    });
    productReply(true, '', ['products' => $items]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) productReply(false, 'Invalid request.', [], 400);

    $id = productText($data['id'] ?? '', 80);
    $name = productText($data['name'] ?? '', 180);
    $sku = strtoupper(productText($data['sku'] ?? '', 80));
    $category = productText($data['category'] ?? 'Other', 120);
    $subcategory = productText($data['subcategory'] ?? '', 120);
    $image = productText($data['image'] ?? '', 300);
    $url = productText($data['url'] ?? '', 300);
    $description = productText($data['description'] ?? '', 1200);
    $price = max(0, (float)($data['price'] ?? 0));
    $stock = max(0, (int)($data['stock'] ?? 0));
    $active = !isset($data['active']) || $data['active'] === true || $data['active'] === '1';

    if ($name === '') productReply(false, 'Product name is required.', [], 422);
    if ($sku !== '') {
        foreach ($items as $item) {
            if (($item['sku'] ?? '') === $sku && ($item['id'] ?? '') !== $id) productReply(false, 'SKU already exists.', [], 422);
        }
    }

    $index = -1;
    foreach ($items as $i => $item) {
        if (($item['id'] ?? '') === $id && $id !== '') { $index = $i; break; }
    }

    $existing = $index >= 0 ? $items[$index] : null;
    $record = [
        'id' => $existing['id'] ?? ('product-' . time() . '-' . bin2hex(random_bytes(3))),
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'url' => $url,
        'description' => $description,
        'stock' => $stock,
        'category' => $category,
        'subcategory' => $subcategory,
        'sku' => $sku,
        'active' => $active,
        'created_at' => $existing['created_at'] ?? date('c'),
        'updated_at' => date('c')
    ];

    if ($index >= 0) $items[$index] = $record; else $items[] = $record;
    if (!productSave($file, $items)) productReply(false, 'Could not save product.', [], 500);
    productReply(true, $index >= 0 ? 'Product updated successfully.' : 'Product added successfully.', ['product' => $record]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = productText($data['id'] ?? '', 80);
    $found = false;
    $remaining = [];
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) $found = true; else $remaining[] = $item;
    }
    if (!$found) productReply(false, 'Product not found.', [], 404);
    if (!productSave($file, $remaining)) productReply(false, 'Could not delete product.', [], 500);
    productReply(true, 'Product deleted successfully.');
}

productReply(false, 'Method not allowed.', [], 405);
