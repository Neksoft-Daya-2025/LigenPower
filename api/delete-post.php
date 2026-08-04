<?php
/**
 * Blog API: Delete a post
 * DELETE api/delete-post.php  with JSON body: { "id": "1" }
 * or POST with same body (for clients that don't support DELETE)
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'] ?? '';
if ($method !== 'DELETE' && $method !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$configFile = __DIR__ . '/../config/posts.json';

if (!file_exists($configFile)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'No posts file found']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$id = isset($data['id']) ? trim((string) $data['id']) : '';

if ($id === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Post id is required']);
    exit;
}

$postsData = json_decode(file_get_contents($configFile), true);
$posts = isset($postsData['posts']) ? $postsData['posts'] : [];

$before = count($posts);
$posts = array_values(array_filter($posts, function ($p) use ($id) {
    return !isset($p['id']) || (string) $p['id'] !== $id;
}));

if (count($posts) === $before) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

$postsData['posts'] = $posts;
$postsData['updated_at'] = date('c');

if (file_put_contents($configFile, json_encode($postsData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save posts']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Post deleted',
    'posts' => $posts,
]);
