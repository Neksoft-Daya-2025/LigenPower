<?php
// Router for PHP built-in server
// This file handles routing for the PHP built-in development server

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Remove leading slash
$requestPath = ltrim($requestPath, '/');

// If it's a PHP file in the api directory, execute it
if (strpos($requestPath, 'api/') === 0) {
    $filePath = __DIR__ . '/' . $requestPath;
    if (file_exists($filePath) && is_file($filePath)) {
        return false; // Let PHP handle it normally
    }
}

// If it's a real file, serve it
if (file_exists(__DIR__ . '/' . $requestPath) && is_file(__DIR__ . '/' . $requestPath)) {
    return false; // Let PHP serve the file
}

// For all other requests, serve index.html (for SPA routing)
if (!file_exists(__DIR__ . '/' . $requestPath) || is_dir(__DIR__ . '/' . $requestPath)) {
    if ($requestPath === '' || $requestPath === '/') {
        readfile(__DIR__ . '/index.html');
        return true;
    }
}

return false;
?>

