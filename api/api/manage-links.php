<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$configFile = __DIR__ . '/../config/page-links.json';

// Default links
$defaultLinks = [
    [
        'id' => '1',
        'label' => 'About Us',
        'url' => 'about-us',
        'icon' => 'home',
        'order' => 1,
        'active' => true
    ],
    [
        'id' => '2',
        'label' => 'Dealers and Distributors',
        'url' => '#/dealers-distributors/',
        'icon' => 'users',
        'order' => 2,
        'active' => false
    ],
    [
        'id' => '3',
        'label' => 'Certifications',
        'url' => 'certificates',
        'icon' => 'certificate',
        'order' => 3,
        'active' => true
    ],
    [
        'id' => '4',
        'label' => 'Store Locator',
        'url' => 'https://merchant.ligenpower.com/',
        'icon' => 'map-pin',
        'order' => 4,
        'active' => true,
        'target' => '_blank'
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get all links
    if (file_exists($configFile)) {
        $links = json_decode(file_get_contents($configFile), true);
        echo json_encode([
            'success' => true,
            'links' => $links
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'links' => $defaultLinks
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new link
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['label']) || !isset($data['url'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Label and URL are required']);
        exit();
    }
    
    // Create config directory if it doesn't exist
    $configDir = __DIR__ . '/../config';
    if (!file_exists($configDir)) {
        mkdir($configDir, 0755, true);
    }
    
    // Load existing links
    $links = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : $defaultLinks;
    
    // Generate new ID
    $maxId = 0;
    foreach ($links as $link) {
        if (isset($link['id']) && intval($link['id']) > $maxId) {
            $maxId = intval($link['id']);
        }
    }
    $newId = (string)($maxId + 1);
    
    // Find max order
    $maxOrder = 0;
    foreach ($links as $link) {
        if (isset($link['order']) && intval($link['order']) > $maxOrder) {
            $maxOrder = intval($link['order']);
        }
    }
    
    $newLink = [
        'id' => $newId,
        'label' => trim($data['label']),
        'url' => trim($data['url']),
        'icon' => isset($data['icon']) ? trim($data['icon']) : 'link',
        'order' => isset($data['order']) ? intval($data['order']) : ($maxOrder + 1),
        'active' => isset($data['active']) ? (bool)$data['active'] : true,
        'target' => isset($data['target']) ? trim($data['target']) : '_self'
    ];
    
    $links[] = $newLink;
    
    // Sort by order
    usort($links, function($a, $b) {
        return ($a['order'] ?? 999) - ($b['order'] ?? 999);
    });
    
    file_put_contents($configFile, json_encode($links, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'message' => 'Link added successfully',
        'link' => $newLink
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Update link
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Link ID is required']);
        exit();
    }
    
    $configDir = __DIR__ . '/../config';
    if (!file_exists($configDir)) {
        mkdir($configDir, 0755, true);
    }
    
    $links = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : $defaultLinks;
    
    $found = false;
    foreach ($links as &$link) {
        if (isset($link['id']) && $link['id'] === $data['id']) {
            if (isset($data['label'])) $link['label'] = trim($data['label']);
            if (isset($data['url'])) $link['url'] = trim($data['url']);
            if (isset($data['icon'])) $link['icon'] = trim($data['icon']);
            if (isset($data['order'])) $link['order'] = intval($data['order']);
            if (isset($data['active'])) $link['active'] = (bool)$data['active'];
            if (isset($data['target'])) $link['target'] = trim($data['target']);
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Link not found']);
        exit();
    }
    
    // Sort by order
    usort($links, function($a, $b) {
        return ($a['order'] ?? 999) - ($b['order'] ?? 999);
    });
    
    file_put_contents($configFile, json_encode($links, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'message' => 'Link updated successfully',
        'links' => $links
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Delete link
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Link ID is required']);
        exit();
    }
    
    $links = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : $defaultLinks;
    
    $links = array_filter($links, function($link) use ($data) {
        return !isset($link['id']) || $link['id'] !== $data['id'];
    });
    
    $links = array_values($links);
    
    file_put_contents($configFile, json_encode($links, JSON_PRETTY_PRINT));
    
    echo json_encode([
        'success' => true,
        'message' => 'Link deleted successfully',
        'links' => $links
    ]);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>

