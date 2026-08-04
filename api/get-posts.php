<?php
/**
 * Blog API: Get list of posts
 * GET api/get-posts.php
 * Query params: limit (int), category (string), published (1|0)
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$configFile = __DIR__ . '/../config/posts.json';

if (!file_exists($configFile)) {
    echo json_encode([
        'success' => true,
        'posts' => [],
        'message' => 'No posts file found'
    ]);
    exit;
}

$data = json_decode(file_get_contents($configFile), true);
$posts = isset($data['posts']) ? $data['posts'] : [];

// Filter by published (default: only published)
$publishedOnly = !isset($_GET['published']) || $_GET['published'] !== '0';
if ($publishedOnly) {
    $posts = array_values(array_filter($posts, function ($p) {
        return !isset($p['published']) || $p['published'] === true;
    }));
}

// Filter by category
if (!empty($_GET['category'])) {
    $category = trim($_GET['category']);
    $posts = array_values(array_filter($posts, function ($p) use ($category) {
        return isset($p['category']) && strcasecmp($p['category'], $category) === 0;
    }));
}

// Sort by date_iso descending (newest first)
usort($posts, function ($a, $b) {
    $da = isset($a['date_iso']) ? $a['date_iso'] : '';
    $db = isset($b['date_iso']) ? $b['date_iso'] : '';
    return strcmp($db, $da);
});

// Limit
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
if ($limit > 0) {
    $posts = array_slice($posts, 0, $limit);
}

// For listing we don't send full content (include published for admin/dashboard)
$list = array_map(function ($p) {
    $item = [
        'id' => $p['id'],
        'slug' => $p['slug'] ?? '',
        'category' => $p['category'] ?? '',
        'title' => $p['title'] ?? '',
        'excerpt' => $p['excerpt'] ?? '',
        'date' => $p['date'] ?? '',
        'date_iso' => $p['date_iso'] ?? '',
        'image' => $p['image'] ?? '',
        'author' => $p['author'] ?? 'Admin',
        'published' => !isset($p['published']) || $p['published'] === true,
    ];
    return $item;
}, $posts);

echo json_encode([
    'success' => true,
    'posts' => $list,
]);
