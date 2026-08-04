# Development Analysis – Ligen Power® Website

Right-from-development analysis of the site structure, pages, backend, and patterns. Use this for onboarding, refactors, or deployment.

---

## 1. Project overview

| Item | Description |
|------|--------------|
| **Site** | Ligen Power® (Amossys) – inverters, batteries, BMS, solar, e-cycles. |
| **Main URL** | https://ligenpower.com (production). |
| **Store locator** | https://merchant.ligenpower.com (Laravel sub-app in `/merchant`). |
| **Stack** | Static HTML + vanilla JS + PHP APIs; no front-end framework. |
| **Server** | PHP required for `api/*.php` and `router.php`. Apache (.htaccess) or PHP built-in server. |

---

## 2. Repository / folder structure

```
LIgen AMossys/
├── index.html              # Homepage
├── router.php              # PHP built-in server router (API + fallback to index)
├── .htaccess               # Apache: PHP, CORS, caching, block direct .json)
├── robots.txt
├── sitemap.xml
├── partials/
│   ├── header.html         # Top bar, nav, announcement (loaded via fetch)
│   └── footer.html         # Footer (loaded via fetch)
├── api/                    # All backend endpoints (PHP)
├── config/                 # JSON + build scripts (data store)
├── assets/
│   ├── css/                # Theme, elementor, swiper, etc.
│   ├── js/                 # jQuery, menus, forms, quote, chatbot
│   ├── images/             # Logos, product images, slides
│   ├── fonts/
│   └── ...
├── uploads/
│   └── blog/               # Blog featured + in-content images
├── dashboard.html          # Admin dashboard (single-page sections)
├── blog.html               # Blog listing
├── blog-single.html        # Single post (id/slug via query)
├── electric-cycle.html     # E-cycles + test ride form
├── user-manual.html        # User manuals (two PDFs only)
├── datasheet.html          # Datasheets listing
├── contact.html, about-us.html, story.html, career.html, certificates.html, news-events.html, ...
├── [product/category pages]  # e.g. power-inverter.html, bms.html, ligen-power-5000.html, bms-1s.html, ...
├── [policy pages]          # privacy-policy, terms-conditions, refund-policy, suggestions-grievances
├── merchant/               # Laravel app for store locator (dealers, states, districts)
├── Ligen-Laravel/          # Optional Laravel migration overlay (apply after Laravel create-project)
└── [docs]                  # CHANGELOG.md, MERCHANT-INTEGRATION.md, SEO-AUDIT.md, etc.
```

---

## 3. Pages inventory

### 3.1 Public – core

| File | Purpose |
|------|--------|
| **index.html** | Homepage. |
| **about-us.html** | About. |
| **contact.html** | Contact. |
| **blog.html** | Blog listing; posts from `api/get-posts.php`. |
| **blog-single.html** | Single post; `?id=1` or slug; content from `api/get-post.php`, fallback in-page. |
| **electric-cycle.html** | E-cycles + “Book a Test Ride” form (city: Jamshedpur/Patna dropdown). |
| **user-manual.html** | Two PDF downloads only (300–5000VA Solar manuals). |
| **datasheet.html** | Datasheets by category. |
| **news-events.html** | News/events listing. |
| **news-single.html** | Single news (template). |
| **tv-narendran-iit-patna-visit.html** | Event page. |
| **certificates.html** | Certifications. |
| **career.html** | Careers. |
| **story.html** | Company story. |
| **abt.html** | Alternate about. |

### 3.2 Public – product & category

- **Category:** power-inverter.html, power-battery.html, bms.html, solar-inverter.html, solar-street-light.html.
- **Grid inverters:** ligen-power-300.html, ligen-power-850.html … ligen-power-5000.html, ligen-power-600s.html.
- **Solar inverters / PCU:** ligen-inv300-pwm.html … ligen-inv5000-48vdc.html, ligen-inv5000-96vdc.html, ligen-inv2000-24vdc.html, ligen-rrv1500-pwm.html.
- **BMS:** bms-1s.html … bms-16s.html.
- **Batteries:** 12v-100ah-lfp-battery.html, 36v-15ah-lfp-battery.html, 48v-lfp-batteries.html.
- **Solar street lights:** 24w-hybrid-solar-street-light.html, 48w-hybrid-solar-street-light.html.

### 3.3 Public – policy & info

- refund-policy.html, privacy-policy.html, terms-conditions.html, suggestions-grievances.html.

### 3.4 Admin / internal

| File | Purpose |
|------|--------|
| **dashboard.html** | Single-page admin: Overview, Products, Test Ride Requests, Announcement, Page Links, Blog Posts, Blog Comments, Merchant/Store Locator (iframe + stats), SMTP, Razorpay, Orders. Header/footer not loaded; standalone. |

### 3.5 Checkout / post-action

- checkout.html, order-success.html.

### 3.6 Test / utility (excluded from sitemap)

- test-menu.html, test-email.html, test-smtp-now.html, test-smtp-integration.html, configure-and-test-smtp.html.

---

## 4. Routing and server

### 4.1 PHP built-in server

- **Command:** `php -S localhost:8000 router.php` (see start-server.bat / start-server.sh).
- **router.php:**  
  - Requests to `api/*.php` → served by PHP.  
  - Existing files → served as-is.  
  - Empty path `/` → serves `index.html`.  
  - Other non-file requests → returns false (PHP serves 404).

### 4.2 Apache (.htaccess)

- **AddHandler** for `.php`.
- **DirectoryIndex** index.html index.php.
- **CORS** on API (Allow-Origin *, methods, Content-Type).
- **Options -Indexes**; Deflate/Expires for static assets; HTML no-cache.
- **.json** in document root denied; API reads config via PHP (config files not under web root in practice or are protected).

---

## 5. Partials (header / footer)

- **partials/header.html** – Top announcement bar (marquee loads from `api/get-announcement.php`), logo, nav (incl. Store Locator → merchant.ligenpower.com), mobile/desktop menus.
- **partials/footer.html** – Footer content and links.
- **Loading:** Most public pages have `<div id="header-placeholder">` and `<div id="footer-placeholder">`. On load they `fetch('partials/header.html')` and `fetch('partials/footer.html')`, then replace placeholders with the HTML and inject menu scripts (`mobile-menu-clean.js`, `desktop-menu-clean.js`), then dispatch `headerLoaded`.
- **index.html** uses the same placeholders; same pattern (fetch and replace).
- **dashboard.html** does not load header/footer; it’s a standalone admin page.

---

## 6. Backend (API)

All under **`api/`**, PHP. Return JSON unless noted.

| Endpoint | Method | Purpose |
|----------|--------|--------|
| **get-posts.php** | GET | List blog posts (`config/posts.json`). Optional `?published=0` for dashboard. |
| **get-post.php** | GET | Single post by `?id=` or `?slug=`. |
| **save-post.php** | POST | Create/update post (writes `config/posts.json`). |
| **delete-post.php** | POST | Delete post by `id`. |
| **upload-image.php** | POST | Blog image upload (writes under `uploads/blog/`). |
| **get-comments.php** | GET | List comments; optional `?post_id=`. Reads `config/comments.json`. |
| **save-comment.php** | POST | Add comment (post_id, name, email, rating, comment). |
| **delete-comment.php** | POST | Delete comment by `id`. |
| **get-announcement.php** | GET | Top bar text. Reads `config/announcement.json`. |
| **manage-links.php** | GET/POST | Page links (e.g. Store Locator). Uses `config/page-links.json` or default. |
| **test-ride-requests.php** | GET | Test ride submissions. Uses `config/test-ride-requests.json`. |
| **get-smtp-config.php** | GET | SMTP settings. |
| **save-smtp-config.php** | POST | Save SMTP. |
| **configure-smtp-test.php** | POST | Test SMTP. |
| **send-email.php** | POST | Send email (e.g. from forms). |
| **create-razorpay-order.php** | POST | Create Razorpay order. |
| **create-order.php** | POST | Create order. |
| **verify-payment.php** | POST | Verify payment. |

APIs use **config/** and **uploads/** under the project; ensure PHP can read/write as needed (e.g. `config/comments.json`, `config/posts.json`).

---

## 7. Config and data files

| File | Purpose |
|------|--------|
| **config/posts.json** | Blog posts (id, slug, title, excerpt, meta_*, date, image, content, published, etc.). |
| **config/comments.json** | Blog comments (id, post_id, name, email, rating, comment, date, created_at). |
| **config/announcement.json** | Top announcement bar text. |
| **config/page-links.json** | Editable links (e.g. Store Locator URL); created/updated by manage-links API. |
| **config/test-ride-requests.json** | Test ride form submissions. |
| **config/smtp-config.json** | SMTP credentials/settings (dashboard). |
| **config/post-content-ligen-evolution.html** | Raw HTML for one post (can be referenced or inlined in posts.json). |
| **config/build-post.js** | Helper to build post entry (e.g. for posts.json). |

**.htaccess** blocks direct access to `.json` in root; API reads config via PHP. Ensure paths in API point to `__DIR__ . '/../config/...'` (or your actual config location).

---

## 8. Assets

- **assets/css/** – Theme (xstore, elementor, swiper, motion-fx, etc.), page-specific post-*.css, template.css, frontend.css, style.css.
- **assets/js/** – jQuery, elementor/frontend, swiper, woocommerce scripts, **mobile-menu-clean.js**, **desktop-menu-clean.js**, **header-loader.js**, **quote-modal.js**, **form-handler.js**, **chatbot.js**, search.js.
- **assets/images/** – Logos, product images, slides (e.g. slide01-min.jpeg).
- **assets/fonts/** – xstore-icons, etc.
- **assets/pdf/** – User manuals (e.g. User Manual 300-5000VA Sola1r.pdf, Solar.pdf).
- **assets/brochures/** – Per-category PDFs (gridinverters, solarinverter, bms, batterypacks, ecycle, solarstreetlignt).
- **uploads/blog/** – Blog featured and in-content images (referenced in posts and post content).

Pages reference assets with relative paths (e.g. `assets/css/...`, `assets/js/...`). Blog post images use paths like `/uploads/blog/...` or relative from root.

---

## 9. Merchant (store locator) sub-project

- **Path:** `merchant/` (Laravel app).
- **URL:** https://merchant.ligenpower.com.
- **Purpose:** Store locator (search by state/district), dealer/distributor management.
- **Tech:** Laravel, MySQL (dealers, states, districts), Blade views, session auth for admin.
- **Public:** Home, Search (state + district → results). **GET** `/search/districts` returns JSON for district dropdown.
- **Admin:** `/admin` – login, dashboard, CRUD dealers, states, districts, CSV import/export. Protected by `admin.auth` middleware.
- **Integration with main site:**  
  - **GET** `https://merchant.ligenpower.com/api/dealer-stats` – JSON counts (total, active, dealers, distributors). CORS enabled.  
  - **Dashboard:** “Merchant / Store Locator” section shows stats and embeds `https://merchant.ligenpower.com/admin` in an iframe.  
  - **AllowEmbedFromMainSite** middleware allows iframe from ligenpower.com and localhost (CSP frame-ancestors).  
- **Default admin (if seeded):** email `admin@ligen.com`, password `admin123` (change in production).

---

## 10. Key development patterns

1. **No SPA:** Each page is a full HTML document; navigation is by links (e.g. `.html`).
2. **Blog:** Listing and single post are data-driven: **blog.html** uses `api/get-posts.php`; **blog-single.html** uses `api/get-post.php?id=` (or slug) and in-page fallback; comments use get/save/delete comment APIs and optional localStorage migration.
3. **Forms:** Test ride (electric-cycle), contact, etc. submit via JS to PHP APIs (e.g. test-ride-requests, send-email). Test ride city is a fixed dropdown (Jamshedpur, Patna).
4. **Dashboard:** Single HTML file with multiple sections; `showSection(sectionId)` toggles visibility; each section loads its own data (e.g. get-posts, get-comments, dealer-stats from merchant).
5. **Announcement:** Header partial fetches `api/get-announcement.php` and updates the marquee; can cache in localStorage.
6. **Menu/nav:** Loaded with header partial; then mobile-menu-clean.js and desktop-menu-clean.js are injected; **headerLoaded** event used where needed.
7. **Paths:** API and asset paths are relative (e.g. `api/get-post.php`, `assets/css/...`). **blog-single.html** computes an **apiBase** from `window.location.pathname` so comment APIs work from any URL depth.

---

## 11. SEO and discovery

- **sitemap.xml** – All public pages and blog post URL; lastmod, changefreq, priority.
- **robots.txt** – Allow /, Sitemap URL.
- **Per-page:** canonical, meta description, OG/Twitter tags (absolute URLs where set). Schema/JSON-LD on key pages.
- **Dashboard, test pages, checkout/order-success** – Not in sitemap; can be Disallow in robots if desired.

---

## 12. Recommendations (development)

1. **Config path:** Keep `config/` outside public web root on production if possible, or ensure .htaccess/restrictions prevent direct access to JSON.
2. **Writable:** Ensure `config/comments.json`, `config/posts.json`, and any other JSON updated by API are writable by the PHP process.
3. **API base:** If you add more pages that call APIs from subpaths, reuse the same `apiBase` pattern as in blog-single (or a small shared script).
4. **CORS:** .htaccess sets broad CORS for API; tighten for production if only same-origin or specific domains need access.
5. **Merchant iframe:** Embedding works only if merchant app is deployed with **AllowEmbedFromMainSite** and same-origin or allowed frame-ancestors; keep CSP in sync with actual parent URLs (e.g. ligenpower.com, www, localhost).
6. **Blog post URL:** Single post is currently loaded as `blog-single.html?id=1`. Sitemap uses a clean URL like `blog/best-electric-bicycle-daily-commute-india-2026-ligen-evolution-series.html`; ensure server or router serves that URL to the same blog-single.html + id/slug if you want pretty URLs.

---

*This document reflects a right-from-development analysis of the Ligen Power® site and pages. Update it when structure or APIs change.*
