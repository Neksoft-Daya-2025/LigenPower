<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{
    protected function getPostsPath(): string
    {
        return storage_path('app/posts.json');
    }

    protected function getPosts(): array
    {
        $path = $this->getPostsPath();
        if (!file_exists($path)) {
            return [];
        }
        $data = json_decode(file_get_contents($path), true);
        return isset($data['posts']) ? $data['posts'] : [];
    }

    protected function normalizeImageUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }
        if (str_starts_with($url, '/')) {
            return $url;
        }
        return '/' . ltrim($url, '/');
    }

    /**
     * Blog listing page.
     */
    public function index(): View
    {
        $posts = $this->getPosts();
        $posts = array_values(array_filter($posts, fn($p) => empty($p['published']) || $p['published']));
        foreach ($posts as &$p) {
            $p['image'] = $this->normalizeImageUrl($p['image'] ?? null);
        }
        return view('blog.index', ['posts' => $posts]);
    }

    /**
     * Single blog post.
     */
    public function show(string $slug): View
    {
        $posts = $this->getPosts();
        $post = null;
        foreach ($posts as $p) {
            if (isset($p['slug']) && $p['slug'] === $slug) {
                $post = $p;
                break;
            }
        }
        if (!$post) {
            abort(404, 'Post not found');
        }
        $post['image'] = $this->normalizeImageUrl($post['image'] ?? null);
        return view('blog.show', ['post' => $post]);
    }
}
