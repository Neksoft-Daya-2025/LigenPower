<?php
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$configFile = __DIR__ . '/../config/announcement.json';

// Default announcement text
$defaultAnnouncement = 'Beat the Heat with Ligen Power Grid / Solar Inverters';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get announcement
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);
        echo json_encode([
            'success' => true,
            'text' => $config['text'] ?? $defaultAnnouncement
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'text' => $defaultAnnouncement
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save announcement
    $data = json_decode(file_get_contents('php://input'), true);
    $text = isset($data['text']) ? trim($data['text']) : $defaultAnnouncement;
    
    // Create config directory if it doesn't exist
    $configDir = __DIR__ . '/../config';
    if (!file_exists($configDir)) {
        mkdir($configDir, 0755, true);
    }
    
    $config = [
        'text' => $text,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'message' => 'Announcement text updated successfully',
        'text' => $text
    ]);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>

