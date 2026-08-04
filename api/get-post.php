<?php
/**
 * Blog API: Get single post by id or slug
 * GET api/get-post.php?id=1  or  api/get-post.php?slug=understanding-bms
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
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

$data = json_decode(file_get_contents($configFile), true);
$posts = isset($data['posts']) ? $data['posts'] : [];

$id = isset($_GET['id']) ? trim($_GET['id']) : '';
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

$post = null;
foreach ($posts as $p) {
    if ($id !== '' && isset($p['id']) && (string) $p['id'] === $id) {
        $post = $p;
        break;
    }
    if ($slug !== '' && isset($p['slug']) && $p['slug'] === $slug) {
        $post = $p;
        break;
    }
}

if (!$post) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

// Only return published posts unless explicitly requesting by id (for preview)
if (isset($post['published']) && $post['published'] === false && $slug !== '') {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

echo json_encode([
    'success' => true,
    'post' => $post,
]);
