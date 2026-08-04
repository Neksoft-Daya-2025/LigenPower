<?php
/**
 * Blog Comments API: Delete a comment by id
 * POST api/delete-comment.php  with JSON body: { "id": "comment-uuid" }
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$configFile = __DIR__ . '/../config/comments.json';

if (!file_exists($configFile)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'No comments file found']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$id = isset($data['id']) ? trim((string) $data['id']) : '';

if ($id === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Comment id is required']);
    exit;
}

$fileData = json_decode(file_get_contents($configFile), true);
$comments = isset($fileData['comments']) ? $fileData['comments'] : [];

$before = count($comments);
$comments = array_values(array_filter($comments, function ($c) use ($id) {
    return !isset($c['id']) || (string) $c['id'] !== $id;
}));

if (count($comments) === $before) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Comment not found']);
    exit;
}

$fileData['comments'] = $comments;
$fileData['updated_at'] = date('c');

if (file_put_contents($configFile, json_encode($fileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save comments']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Comment deleted',
    'comments' => $comments,
]);
