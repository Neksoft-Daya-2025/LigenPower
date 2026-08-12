<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$file = __DIR__ . '/../config/dealer-users.json';

function dealerAdminReply($success, $message = '', $extra = [], $status = 200) {
    http_response_code($status);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra), JSON_UNESCAPED_SLASHES);
    exit;
}

function dealerAdminText($value, $max = 500) {
    $value = trim((string)$value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

function dealerAdminLoad($file) {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) && isset($data['users']) && is_array($data['users']) ? $data['users'] : [];
}

function dealerAdminSave($file, $users) {
    $dir = dirname($file);
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    return file_put_contents($file, json_encode(['users' => array_values($users), 'updated_at' => date('c')], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}

function dealerAdminPublicUser($user) {
    unset($user['password']);
    unset($user['password_hash']);
    return $user;
}

$users = dealerAdminLoad($file);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $safeUsers = array_map('dealerAdminPublicUser', $users);
    usort($safeUsers, function($a, $b) {
        return strcmp($a['name'] ?? '', $b['name'] ?? '');
    });
    dealerAdminReply(true, '', ['users' => $safeUsers]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) dealerAdminReply(false, 'Invalid request.', [], 400);

    $id = dealerAdminText($data['id'] ?? '', 100);
    $name = dealerAdminText($data['name'] ?? '', 180);
    $company = dealerAdminText($data['company'] ?? '', 180);
    $email = strtolower(dealerAdminText($data['email'] ?? '', 180));
    $role = strtolower(dealerAdminText($data['role'] ?? 'dealer', 40));
    $password = (string)($data['password'] ?? '');
    $active = !isset($data['active']) || $data['active'] === true || $data['active'] === '1';

    if ($name === '') dealerAdminReply(false, 'Name is required.', [], 422);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) dealerAdminReply(false, 'Valid email is required.', [], 422);
    if (!in_array($role, ['dealer', 'distributor'], true)) dealerAdminReply(false, 'Invalid account type.', [], 422);

    $index = -1;
    foreach ($users as $i => $user) {
        if (($user['id'] ?? '') === $id && $id !== '') $index = $i;
        if (strtolower($user['email'] ?? '') === $email && ($user['id'] ?? '') !== $id) dealerAdminReply(false, 'Email already exists.', [], 422);
    }
    $existing = $index >= 0 ? $users[$index] : null;
    if (!$existing && strlen($password) < 8) dealerAdminReply(false, 'Password must be at least 8 characters.', [], 422);
    if ($existing && $password !== '' && strlen($password) < 8) dealerAdminReply(false, 'Password must be at least 8 characters.', [], 422);

    $record = [
        'id' => $existing['id'] ?? ('dealer-' . time() . '-' . bin2hex(random_bytes(3))),
        'name' => $name,
        'company' => $company,
        'email' => $email,
        'password_hash' => $password !== '' ? password_hash($password, PASSWORD_DEFAULT) : ($existing['password_hash'] ?? ''),
        'role' => $role,
        'active' => $active,
        'created_at' => $existing['created_at'] ?? date('c'),
        'updated_at' => date('c')
    ];

    if ($record['password_hash'] === '') dealerAdminReply(false, 'Password is required.', [], 422);
    if ($index >= 0) $users[$index] = $record; else $users[] = $record;
    if (!dealerAdminSave($file, $users)) dealerAdminReply(false, 'Could not save account.', [], 500);
    dealerAdminReply(true, $index >= 0 ? 'Dealer account updated.' : 'Dealer account created.', ['user' => dealerAdminPublicUser($record)]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = dealerAdminText($data['id'] ?? '', 100);
    $found = false;
    $remaining = [];
    foreach ($users as $user) {
        if (($user['id'] ?? '') === $id) $found = true; else $remaining[] = $user;
    }
    if (!$found) dealerAdminReply(false, 'Dealer account not found.', [], 404);
    if (!dealerAdminSave($file, $remaining)) dealerAdminReply(false, 'Could not delete account.', [], 500);
    dealerAdminReply(true, 'Dealer account deleted.');
}

dealerAdminReply(false, 'Method not allowed.', [], 405);
