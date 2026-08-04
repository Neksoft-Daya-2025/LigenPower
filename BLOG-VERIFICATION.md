# Blog System – Verification Checklist

## Quick check (with server running)

1. **Start the server**
   ```bash
   php -S localhost:8000 router.php
   ```

2. **Blog listing** – http://localhost:8000/blog.html  
   - Should show 2 sample posts (BMS guide, Solar street lighting).  
   - Click a post → opens single post page.

3. **Single post** – http://localhost:8000/blog-single.html?id=1  
   - Title, category, date, content, and featured image load from API.  
   - Page title and meta description (and OG/Twitter) update for SEO.

4. **Dashboard – Blog Posts** – http://localhost:8000/dashboard.html → **Blog Posts**  
   - List shows all posts (including drafts if any).  
   - **Add Post**: fill form, date picker, Quill content, optional meta description/keywords, optional image upload → Add Post.  
   - **Edit**: click Edit on a row → form fills → change and Update Post.  
   - **Delete**: click Delete → confirm → post removed from list.  
   - **Image upload**: choose file → Upload image → URL and preview update.  
   - **Quill**: type in content, use toolbar (bold, lists, link, image upload).  
   - **SEO**: Meta description and Meta keywords save and appear on single post page.

5. **API (optional)**  
   - GET http://localhost:8000/api/get-posts.php → JSON with `posts` array.  
   - GET http://localhost:8000/api/get-post.php?id=1 → JSON with `post` object.

## What was verified

- **config/posts.json** – Valid structure; 2 sample posts with meta_description/meta_keywords.
- **api/get-posts.php** – Returns list (with `published` for dashboard).
- **api/get-post.php** – Returns single post by id or slug; 404 when not found.
- **api/save-post.php** – Saves meta_description, meta_keywords, and all post fields.
- **api/delete-post.php** – Deletes by id (POST body `{"id":"1"}`).
- **api/upload-image.php** – Accepts image upload; saves to `uploads/blog/`; returns URL.
- **blog.html** – Fetches API, renders cards; shows “No posts yet” when empty; handles errors.
- **blog-single.html** – Fetches post by id; updates title, meta description, keywords, OG, Twitter; fallback to static `blogPosts` if API fails.
- **dashboard.html** – Blog form: title, slug, category, date picker, image (upload + URL), author, excerpt, SEO (meta description, meta keywords), Quill content, published; list with Edit/Delete; all IDs and handlers present.

## If something fails

- **“Failed to load posts”** – Ensure PHP server is running with `router.php` (not a static file server).
- **404 on get-post** – Check `config/posts.json` has a post with that `id`.
- **Image upload fails** – Ensure `uploads/blog/` is writable (created automatically by API).
- **Quill not showing** – Check browser console; Quill loads from CDN (https://cdn.quilljs.com/1.3.7/).
