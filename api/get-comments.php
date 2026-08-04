<?php
/**
 * Blog Comments API: Get comments (optionally by post_id)
 * GET api/get-comments.php  or  api/get-comments.php?post_id=1
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

$configFile = __DIR__ . '/../config/comments.json';

if (!file_exists($configFile)) {
    echo json_encode(['success' => true, 'comments' => []]);
    exit;
}

$data = json_decode(file_get_contents($configFile), true);
$comments = isset($data['comments']) ? $data['comments'] : [];

$postId = isset($_GET['post_id']) ? trim((string) $_GET['post_id']) : '';
if ($postId !== '') {
    $comments = array_values(array_filter($comments, function ($c) use ($postId) {
        return isset($c['post_id']) && (string) $c['post_id'] === $postId;
    }));
}

echo json_encode([
    'success' => true,
    'comments' => $comments,
]);
