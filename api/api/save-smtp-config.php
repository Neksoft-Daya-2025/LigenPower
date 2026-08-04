<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['config'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing config data']);
    exit;
}

$config = $data['config'];
$configDir = __DIR__ . '/../config';

// Create config directory if it doesn't exist
if (!is_dir($configDir)) {
    mkdir($configDir, 0755, true);
}

$configFile = $configDir . '/smtp-config.json';

if (file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'SMTP config saved successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save SMTP config']);
}
?>

