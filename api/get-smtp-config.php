<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Read SMTP config from localStorage backup file or return default
$configFile = __DIR__ . '/../config/smtp-config.json';

if (file_exists($configFile)) {
    $config = json_decode(file_get_contents($configFile), true);
    if ($config && isset($config['host'])) {
        echo json_encode(['success' => true, 'config' => $config]);
        exit;
    }
}

// Try to read from localStorage backup (if available via session)
// For now, return empty config - frontend will handle fallback
echo json_encode(['success' => false, 'message' => 'SMTP not configured', 'config' => null]);
?>

