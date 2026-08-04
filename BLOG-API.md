# Blog System – Backend API

The blog is driven by a JSON-backed API. Posts are stored in `config/posts.json`.

## Endpoints

### List posts (for blog listing page)

- **URL:** `GET api/get-posts.php`
- **Query (optional):**
  - `limit` – max number of posts (e.g. `?limit=10`)
  - `category` – filter by category name
  - `published=0` – include unpublished posts (default is published only)
- **Response:** `{ "success": true, "posts": [ { "id", "slug", "category", "title", "excerpt", "date", "date_iso", "image", "author" }, ... ] }`

### Get single post (for blog single page)

- **URL:** `GET api/get-post.php?id=1` or `api/get-post.php?slug=understanding-bms`
- **Response:** `{ "success": true, "post": { "id", "slug", "category", "title", "excerpt", "date", "date_iso", "image", "author", "content", "published", ... } }`
- **404:** `{ "success": false, "message": "Post not found" }`

### Delete a post (admin)

- **URL:** `POST api/delete-post.php` or `DELETE api/delete-post.php`
- **Body (JSON):** `{ "id": "1" }`
- **Response:** `{ "success": true, "message": "Post deleted", "posts": [ ... ] }`
- **404:** Post not found.

### Create or update a post (admin)

- **URL:** `POST api/save-post.php`
- **Headers:** `Content-Type: application/json`
- **Body (JSON):**
  - **Create:** omit `id` or send new post data. Required: `title`. Optional: `slug`, `category`, `excerpt`, `meta_description`, `meta_keywords`, `date`, `date_iso`, `image`, `author`, `content`, `published`.
  - **Update:** send `id` of existing post plus any fields to update. `title` is required.
- **Example create:**
  ```json
  {
    "title": "My New Post",
    "category": "Solar Solutions",
    "excerpt": "Short summary.",
    "date": "January 31, 2025",
    "date_iso": "2025-01-31",
    "image": "assets/images/slide01-min.jpeg",
    "author": "Admin",
    "content": "<p>Full HTML content here.</p>",
    "published": true
  }
  ```
- **Response:** `{ "success": true, "message": "Post created"|"Post updated", "post": { ... } }`

## Data file

- **Path:** `config/posts.json`
- **Structure:** `{ "posts": [ { "id", "slug", "category", "title", "excerpt", "meta_description", "meta_keywords", "date", "date_iso", "image", "author", "content", "published", "created_at", "updated_at" }, ... ], "updated_at": "..." }`
- You can edit this file by hand or via `api/save-post.php`. New posts get the next numeric `id` and a `slug` derived from the title if not provided.

## Frontend

- **blog.html** – Fetches `api/get-posts.php` and renders the blog grid.
- **blog-single.html** – Fetches `api/get-post.php?id=...` and renders the post; if the API fails, it falls back to the built-in static post data.
- **dashboard.html** – Admin: **Blog Posts** in the sidebar. List all posts (including drafts), **Add New Post**, **Edit** (loads post into form), **Delete** (with confirm). Uses `api/get-posts.php?published=0`, `api/get-post.php?id=...`, `api/save-post.php`, and `api/delete-post.php`.

## Running locally

Use the PHP built-in server so that `api/*.php` is executed:

```bash
php -S localhost:8000 router.php
```

Then open:

- http://localhost:8000/blog.html – blog listing
- http://localhost:8000/blog-single.html?id=1 – single post
