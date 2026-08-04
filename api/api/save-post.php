<?php
/**
 * Blog API: Create or update a post
 * POST api/save-post.php
 * Body: JSON { id?, slug, category, title, excerpt, date, date_iso, image, author, content, published }
 * - If id is provided and exists: update. Otherwise: create new post.
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

$configDir = __DIR__ . '/../config';
$configFile = $configDir . '/posts.json';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON body']);
    exit;
}

// Load existing posts
$postsData = ['posts' => [], 'updated_at' => date('c')];
if (file_exists($configFile)) {
    $existing = json_decode(file_get_contents($configFile), true);
    if (is_array($existing)) {
        $postsData['posts'] = isset($existing['posts']) ? $existing['posts'] : [];
    }
}

$posts = &$postsData['posts'];

// Build post from request (allow partial for update)
$title = isset($data['title']) ? trim($data['title']) : '';
if ($title === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Title is required']);
    exit;
}

$slug = isset($data['slug']) ? trim($data['slug']) : strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
$slug = trim($slug, '-');
if ($slug === '') {
    $slug = 'post-' . time();
}

$id = isset($data['id']) ? trim((string) $data['id']) : null;
$isUpdate = false;
$index = -1;

if ($id !== null && $id !== '') {
    foreach ($posts as $i => $p) {
        if (isset($p['id']) && (string) $p['id'] === $id) {
            $isUpdate = true;
            $index = $i;
            break;
        }
    }
}

$now = date('c');
$dateStr = isset($data['date']) ? trim($data['date']) : date('F j, Y');
$dateIso = isset($data['date_iso']) ? trim($data['date_iso']) : date('Y-m-d');

$post = [
    'id' => $id ?? (string) (count($posts) + 1),
    'slug' => $slug,
    'category' => isset($data['category']) ? trim($data['category']) : 'Uncategorized',
    'title' => $title,
    'excerpt' => isset($data['excerpt']) ? trim($data['excerpt']) : '',
    'meta_description' => isset($data['meta_description']) ? trim($data['meta_description']) : '',
    'meta_keywords' => isset($data['meta_keywords']) ? trim($data['meta_keywords']) : '',
    'date' => $dateStr,
    'date_iso' => $dateIso,
    'image' => isset($data['image']) ? trim($data['image']) : 'assets/images/slide01-min.jpeg',
    'author' => isset($data['author']) ? trim($data['author']) : 'Admin',
    'content' => isset($data['content']) ? $data['content'] : '',
    'published' => !isset($data['published']) || $data['published'] === true || $data['published'] === '1',
    'created_at' => $isUpdate && isset($posts[$index]['created_at']) ? $posts[$index]['created_at'] : $now,
    'updated_at' => $now,
];

if ($isUpdate) {
    $posts[$index] = $post;
} else {
    // New post: ensure unique id
    $maxId = 0;
    foreach ($posts as $p) {
        $n = (int) (isset($p['id']) ? $p['id'] : 0);
        if ($n > $maxId) $maxId = $n;
    }
    $post['id'] = (string) ($maxId + 1);
    $post['created_at'] = $now;
    $posts[] = $post;
}

// Sort by date_iso desc
usort($posts, function ($a, $b) {
    $da = isset($a['date_iso']) ? $a['date_iso'] : '';
    $db = isset($b['date_iso']) ? $b['date_iso'] : '';
    return strcmp($db, $da);
});

$postsData['updated_at'] = $now;

if (!file_exists($configDir)) {
    mkdir($configDir, 0755, true);
}

if (file_put_contents($configFile, json_encode($postsData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save posts']);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => $isUpdate ? 'Post updated' : 'Post created',
    'post' => $post,
]);
