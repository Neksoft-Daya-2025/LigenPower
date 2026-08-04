<?php
/**
 * Blog Comments API: Add a comment
 * POST api/save-comment.php  with JSON body: { "post_id": "1", "name": "...", "email": "...", "rating": 5, "comment": "..." }
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

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$postId = isset($data['post_id']) ? trim((string) $data['post_id']) : '';
$name = isset($data['name']) ? trim((string) $data['name']) : '';
$email = isset($data['email']) ? trim((string) $data['email']) : '';
$rating = isset($data['rating']) ? (int) $data['rating'] : 0;
$commentText = isset($data['comment']) ? trim((string) $data['comment']) : '';

if ($postId === '' || $name === '' || $email === '' || $commentText === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'post_id, name, email, and comment are required']);
    exit;
}

if ($rating < 1 || $rating > 5) {
    $rating = 5;
}

$date = date('F j, Y'); // e.g. January 31, 2026
$createdAt = date('c');
$id = 'c-' . time() . '-' . bin2hex(random_bytes(4));

$comment = [
    'id' => $id,
    'post_id' => $postId,
    'name' => $name,
    'email' => $email,
    'rating' => $rating,
    'comment' => $commentText,
    'date' => $date,
    'created_at' => $createdAt,
];

if (!file_exists($configFile)) {
    $fileData = ['comments' => [], 'updated_at' => ''];
} else {
    $fileData = json_decode(file_get_contents($configFile), true);
    if (!isset($fileData['comments'])) {
        $fileData['comments'] = [];
    }
}

$fileData['comments'][] = $comment;
$fileData['updated_at'] = $createdAt;

$configDir = dirname($configFile);
if (!is_dir($configDir)) {
    mkdir($configDir, 0755, true);
}

if (file_put_contents($configFile, json_encode($fileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save comment']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Comment added',
    'comment' => $comment,
]);
