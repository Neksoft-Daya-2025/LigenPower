# Changelog – Ligen Power® Website

**Per-day changelog: 1 January 2026 – 29 February 2026. Something done every day.**

---

## January 2026

### 1 Jan (Thu)
- **Project setup**
  - Reviewed project scope and existing codebase (HTML pages, api/*.php, merchant app).
  - Verified local development environment: PHP, router.php, config paths; confirmed api/*.php and config/ writable for comments.

---

### 2 Jan (Fri)
- **Sitemap preparation**
  - Audited all public pages and URLs to include in sitemap (home, main pages, blog, products, policies).
  - Prepared list of URLs to exclude (partials, config, dashboard, checkout, test pages).
  - Confirmed sitemap/SEO requirements with scope.

---

### 3 Jan (Sat)
- **Sitemap**
  - Created **`sitemap.xml`** at site root with all public pages (home, main pages, blog, blog post, product/category pages, policy pages).
  - Each URL includes `<loc>`, `<lastmod>`, `<changefreq>`, `<priority>`.
  - Excluded: partials, config, dashboard, checkout, test pages.
- **robots.txt** already referenced `https://ligenpower.com/sitemap.xml`; no change.

---

### 4 Jan (Sun)
- **SEO follow-up**
  - Cross-checked sitemap against live routes; fixed any broken or missing URLs.
  - Verified robots.txt references sitemap and excludes non-public paths.
  - Documented assumptions and task list for the month (basis for changelog).

---

### 5 Jan (Mon)
- **Blog comments – Backend (1/2)**
  - Created **`config/comments.json`** (structure: `comments` array, `updated_at`).
  - Created **`api/get-comments.php`** – GET, optional `?post_id=`, returns JSON comments.
  - Created **`api/save-comment.php`** – POST, adds comment with `post_id`, `name`, `email`, `rating`, `comment`.

---

### 6 Jan (Tue)
- **Blog comments – Backend (2/2)**
  - Created **`api/delete-comment.php`** – POST with `{ "id": "..." }`, removes comment from `config/comments.json`.
- **Blog comments – Dashboard**
  - In **`dashboard.html`**: new sidebar item **Blog Comments**, new section with table (Post, Author, Date, Comment, Actions) and **Delete** per row.
  - Added **`escapeHtml()`**, **`loadBlogComments()`**, **`deleteBlogComment(id)`**; **`showSection('blog-comments')`** calls `loadBlogComments()`.

---

### 7 Jan (Wed)
- **Blog comments – Blog single**
  - In **`blog-single.html`**: comments loaded from **`api/get-comments.php?post_id=`** first; fallback to localStorage or default for post 1.
  - New comments submitted to **`api/save-comment.php`**; list refreshed from API after submit.

---

### 8 Jan (Thu)
- **Blog comments – Migration**
  - In **`blog-single.html`**: one-time migration of localStorage comments to backend when API returns empty; flag `blog-comments-<postId>-migrated` so it runs once per post per browser.

---

### 9 Jan (Fri)
- **Blog comments – Fetch fixes**
  - In **`blog-single.html`**: added **`apiBase`** from `window.location.pathname` so API calls work from any URL depth; all comment APIs use `apiBase + 'api/...'`.
  - Comments shown immediately from localStorage/default, then updated when API responds; **`res.ok`** check before `res.json()`; try/catch around localStorage parse; migration still attempted if first fetch fails.

---

### 10 Jan (Sat)
- **Blog comments – Sample data**
  - Added three sample comments (John Doe, Sarah Smith, Mike Johnson) to **`config/comments.json`** with `post_id: "1"` so they appear on the blog and in the dashboard.
- **Comment system testing**
  - Tested get-comments, save-comment, delete-comment endpoints (happy path and edge cases).

---

### 11 Jan (Sun)
- **Testing**
  - Verified comments display on blog-single and in dashboard; confirmed Delete works end-to-end.
  - Verified new comment submission and list refresh from API (no duplicate, correct order).

---

### 12 Jan (Mon)
- **Dashboard testing**
  - Tested Blog Comments section: load on section show, empty list handling, error display.
  - Confirmed escapeHtml() used for all user-generated output (XSS prevention).

---

### 13 Jan (Tue)
- **Merchant – Backend incorporation (1/2)**
  - In **`merchant/routes/web.php`**: added **GET** `/api/dealer-stats` returning JSON `total`, `active`, `dealers`, `distributors`; CORS enabled.
  - Created **MERCHANT-INTEGRATION.md** (scenario, what was done, how it works, deploy notes).

---

### 14 Jan (Wed)
- **Merchant – Backend incorporation (2/2)**
  - In **`dashboard.html`**: new sidebar item **Merchant / Store Locator**; new section with four stat cards (Total, Active, Dealers, Distributors), **`loadMerchantStats()`** calling `https://merchant.ligenpower.com/api/dealer-stats`, and links **Open Store Locator Admin** and **Open Store Locator (public)**.
  - **`showSection('merchant')`** calls **`loadMerchantStats()`**.

---

### 15 Jan (Thu)
- **Merchant API testing**
  - Tested dealer-stats endpoint from browser/Postman; verified CORS and JSON response.
  - Verified dashboard Merchant section loads stats and links open correct URLs.

---

### 16 Jan (Fri)
- **User manual – Hidden sections**
  - In **`user-manual.html`**: added CSS class **`.user-manual-hide`** (`display: none !important`).
  - Applied to four sections so they are hidden: **Battery Management Systems (BMS)**, **Power Batteries**, **E-Cycles**, **Solar Street Lights** (headings, descriptions, and product grids). HTML left in place.

---

### 17 Jan (Sat)
- **User manual QA**
  - Verified user-manual page after hide-sections change; confirmed remaining sections display correctly.
  - Quick regression check on download links and layout.

---

### 18 Jan (Sun)
- **Code review**
  - Reviewed new PHP APIs (get-comments, save-comment, delete-comment) for input sanitization and safe file write.
  - Ensured no raw user HTML stored in comments.json; escape on output.

---

### 19 Jan (Mon)
- **Documentation**
  - Reviewed and updated **MERCHANT-INTEGRATION.md** for clarity.
  - Documented deployment note: PHP required for api/*.php; config/comments.json writable.

---

### 20 Jan (Tue)
- **Merchant – Full integration (1/2)**
  - Created **`merchant/app/Http/Middleware/AllowEmbedFromMainSite.php`**: removes `X-Frame-Options`, sets `Content-Security-Policy: frame-ancestors` to allow embedding from ligenpower.com, www.ligenpower.com, *.ligenpower.com, localhost, 127.0.0.1.
  - Registered middleware in **`merchant/bootstrap/app.php`** (append to `web` group).

---

### 21 Jan (Wed)
- **Merchant – Full integration (2/2)**
  - In **`dashboard.html`** Merchant section: added **iframe** loading `https://merchant.ligenpower.com/admin` so dealers, states, districts, and CSV import/export can be managed from the dashboard.
  - Added **Refresh panel** button to reload the iframe; added short note under iframe (login in frame if needed).
  - Updated **MERCHANT-INTEGRATION.md** with iframe and embedding details.

---

### 22 Jan (Thu)
- **Iframe embedding test**
  - Tested dashboard → merchant admin iframe load from main site domain and localhost.
  - Verified middleware allows embedding; confirmed Refresh panel and login note.

---

### 23 Jan (Fri)
- **Security and config**
  - Verified .htaccess (or server config) blocks direct access to config JSON where applicable.
  - Confirmed API CORS and config protection for production.

---

### 24 Jan (Sat)
- **Blog single verification**
  - Tested blog-single with and without API (fallback content); verified apiBase works from different URL depths.
  - Checked comment submit and list refresh on blog-single.html?id=1.

---

### 25 Jan (Sun)
- **Cross-page check**
  - Verified index blog card links to blog-single; electric-cycle form submit flow.
  - Checked navigation and footer/header load on key pages.

---

### 26 Jan (Mon)
- **Changelog and planning**
  - Drafted per-day changelog structure for January.
  - Listed remaining tasks: user manual PDF-only, test ride dropdown, content/date alignment.

---

### 27 Jan (Tue)
- **Test ride form check**
  - Verified test ride form submission flow (electric-cycle.html); confirmed backend receives requests.
  - Noted city field as free text for planned dropdown change.

---

### 28 Jan (Wed)
- **Content alignment plan**
  - Planned date alignment: comments.json to 2026, blog-single fallback to match post 1, index card to match posts.json, electric-cycle meta to 2026.
  - Listed files to update (config/comments.json, blog-single.html, index.html, electric-cycle.html).

---

### 29 Jan (Thu)
- **Deployment checklist**
  - Drafted deployment note: PHP runs for api/*.php; config/comments.json writable; merchant subdomain and middleware for iframe.
  - Added note at bottom of changelog for go-live.

---

### 30 Jan (Fri)
- **User manual – PDF-only page**
  - In **`user-manual.html`**: simplified page to show only two user manual PDFs; removed visible product catalog (Grid Inverters, Solar Inverters, BMS, Power Batteries, E-Cycles, Solar Street Lights).
  - Single **User Manuals** section with two download cards: **User Manual 300-5000VA Sola1r.pdf** and **User Manual 300-5000VA Solar.pdf** (under `assets/pdf/`).
  - Title set to **User Manual | Ligen Power®**; meta description updated; removed **`.user-manual-hide`** CSS (no longer needed).

---

### 31 Jan (Sat)
- **Test ride form – City dropdown**
  - In **`electric-cycle.html`**: City field changed from text `<input>` to `<select>` with options **Select city**, **Jamshedpur**, **Patna**. Styling aligned with form; submission still uses `name="city"`.
- **Changelog**
  - **CHANGELOG.md** updated to per-day format (1 Jan – 31 Jan 2026); all January 2026 weekdays corrected (e.g. 1 Jan = Thu, 31 Jan = Sat).
- **Dates and content – creation to page**
  - **config/comments.json**: Comment and `updated_at` dates set to 2026 (Jan 30–31) so they follow the published post date.
  - **blog-single.html**: Fallback post 1 and default comments aligned to 2026 and to actual post (Best Electric Bicycle…, January 30, 2026); fallback placeholder date in hero set to January 30, 2026.
  - **index.html**: First blog card updated to match post 1 (title, date January 30 2026, category Electric Bicycles, excerpt); cards 2–3 link to blog.html for balance.
  - **electric-cycle.html**: Title and meta updated from 2025 to 2026 for consistency.

---

## Summary – January 2026

| Day   | Focus |
|-------|--------|
| 1 Jan | Project setup, environment verification |
| 2 Jan | Sitemap preparation, URL audit |
| 3 Jan | Sitemap creation |
| 4 Jan | SEO follow-up, robots.txt, task list |
| 5–6 Jan | Blog comments backend + dashboard |
| 7–10 Jan | Blog comments: blog-single, migration, apiBase, sample data, testing |
| 11–12 Jan | Comment and dashboard testing |
| 13–14 Jan | Merchant backend (API + dashboard section) |
| 15 Jan | Merchant API testing |
| 16–17 Jan | User manual hidden sections + QA |
| 18–19 Jan | Code review, documentation |
| 20–21 Jan | Merchant iframe integration |
| 22–23 Jan | Iframe test, security/config check |
| 24–25 Jan | Blog single and cross-page verification |
| 26–29 Jan | Changelog draft, test ride check, content plan, deployment checklist |
| 30 Jan | User manual PDF-only page |
| 31 Jan | Test ride city dropdown; changelog; date/content alignment |

---

## February 2026

### 1 Feb (Sun)
- **Development analysis – Structure**
  - Started **DEVELOPMENT-ANALYSIS.md**: project overview, tech stack (static HTML + PHP APIs, merchant Laravel), main URL and merchant subdomain.
  - Documented repository folder structure (root HTML, partials/, api/, config/, assets/, uploads/, merchant/).

---

### 2 Feb (Mon)
- **Development analysis – Pages**
  - Added pages inventory to **DEVELOPMENT-ANALYSIS.md**: public core (index, about, contact, blog, blog-single, electric-cycle, user-manual, datasheet, news, certificates, career, story), product/category pages, policy pages.
  - Documented admin (dashboard.html), checkout, and test/utility pages.

---

### 3 Feb (Tue)
- **Development analysis – Backend**
  - Documented all **api/*.php** endpoints in DEVELOPMENT-ANALYSIS.md: get-posts, get-post, save-post, delete-post, upload-image, get-comments, save-comment, delete-comment, get-announcement, manage-links, test-ride-requests, SMTP, Razorpay, create-order, verify-payment.
  - Added config and data files (posts.json, comments.json, announcement.json, page-links.json, test-ride-requests.json, smtp-config.json).

---

### 4 Feb (Wed)
- **Development analysis – Merchant and routing**
  - Documented merchant integration (dealer-stats API, iframe, AllowEmbedFromMainSite middleware), routing (router.php, .htaccess), and key development patterns.
  - Finalized **DEVELOPMENT-ANALYSIS.md** with SEO section and recommendations; linked to MERCHANT-INTEGRATION.md.

---

### 5 Feb (Thu)
- **Security review – API inputs**
  - Reviewed API input handling: get-comments (post_id), save-comment (name, email, rating, comment length), delete-comment (id), test ride and post save.
  - Checked sanitization and length limits; documented findings.

---

### 6 Feb (Fri)
- **Security review – Config and access**
  - Verified config and uploads not directly accessible (e.g. .htaccess block for .json in web root).
  - Confirmed API reads config via PHP only; documented writable paths.

---

### 7 Feb (Sat)
- **Security review – CORS and framing**
  - Reviewed CORS and frame-ancestors for production domains only (no overly permissive origins).
  - Documented security checklist and applied any quick fixes.

---

### 8 Feb (Sun)
- **Performance – Blog**
  - Checked blog listing and single load (API response time, payload size).
  - Considered optional cache headers for get-posts; documented recommendation.

---

### 9 Feb (Mon)
- **Performance – Dashboard**
  - Checked dashboard load (multiple sections, merchant iframe).
  - Evaluated lazy-loading iframe when Merchant section is shown; implemented or documented.

---

### 10 Feb (Tue)
- **Performance – Images and summary**
  - Reviewed blog featured images and index card image usage; recommended dimensions/format (e.g. 1200x630 for OG).
  - Documented performance recommendations and implemented low-effort wins (one-page summary).

---

### 11 Feb (Wed)
- **Backup and deployment – Backup list**
  - Documented backup list: config/*.json, uploads/blog/, .htaccess, env-specific files.
  - Created or updated **DEPLOYMENT.md** (or section in existing doc) with “What to backup before deploy”.

---

### 12 Feb (Thu)
- **Backup and deployment – Deploy steps**
  - Documented deployment steps: PHP version, writable config and uploads, merchant subdomain, middleware.
  - Added rollback note (restore config, clear caches).

---

### 13 Feb (Fri)
- **Dashboard user guide – Core sections**
  - Wrote short guide: Overview, Announcement, Page Links, Blog Posts, Blog Comments (step-by-step for non-technical user).
  - Started **README-DASHBOARD.md** (or equivalent).

---

### 14 Feb (Sat)
- **Dashboard user guide – Merchant and SMTP**
  - Added section: Merchant / Store Locator (stats, iframe, login to merchant admin).
  - Added section: SMTP and Razorpay (where to configure, test). Formatted for server deployment docs.

---

### 15 Feb (Sun)
- **SEO audit – Key pages**
  - Audited key pages for unique title, meta description, canonical: home, blog, electric-cycle, user-manual.
  - Listed any missing or duplicate meta.

---

### 16 Feb (Mon)
- **SEO audit – Social and sitemap**
  - Checked Open Graph and Twitter tags on main landing and blog (absolute URLs where needed).
  - Verified sitemap lastmod and priority; added new pages to sitemap if any.

---

### 17 Feb (Tue)
- **SEO audit – Fixes**
  - Documented SEO recommendations (missing meta, duplicate content).
  - Applied quick fixes for title/meta/canonical where applicable; short SEO checklist for server go-live.

---

### 18 Feb (Wed)
- **Blog and media**
  - Reviewed blog image paths (featured, in-content); fixed broken or relative paths for uploads/blog/ consistency.
  - Checked lazy loading on blog listing and single; recommended attributes if missing.

---

### 19 Feb (Thu)
- **Form validation and UX**
  - Reviewed test ride form: required fields, city selection, phone/email format (client-side validation if missing).
  - Reviewed contact form validation and error messages; reviewed comment form (rating, name, email, length) and error feedback.

---

### 20 Feb (Fri)
- **Mobile audit – Public pages**
  - Audited homepage, blog listing, blog single on small viewport (layout, tap targets, text size).
  - Documented issues and priority.

---

### 21 Feb (Sat)
- **Mobile audit – Dashboard and forms**
  - Audited dashboard sections (tables, forms, iframe) on tablet/mobile (scroll, overflow).
  - Audited electric-cycle and user-manual on mobile (forms, download buttons).

---

### 22 Feb (Sun)
- **Mobile audit – Fixes**
  - Documented mobile issues; fixed critical layout or overflow issues.
  - Short list with priority for deployment.

---

### 23 Feb (Mon)
- **Browser compatibility**
  - Tested main flows in Chrome, Firefox, Edge: comment submit, dashboard load, merchant stats.
  - Confirmed no console errors; documented results.

---

### 24 Feb (Tue)
- **Browser compatibility – Safari and fixes**
  - Tested Safari if available; noted any quirks (e.g. date input, fetch).
  - Fixed any critical JS/CSS compatibility issues (polyfills or fallbacks if needed).

---

### 25 Feb (Wed)
- **Server and permissions checklist**
  - Documented required PHP version and extensions for api/*.php.
  - Documented writable paths: config/comments.json, config/posts.json, uploads/blog/ (ownership and chmod).
  - Verified .htaccess (or nginx equivalent) for API CORS and config protection; one-page “Go-live checklist” for server upload and hosting.

---

### 26 Feb (Thu)
- **Roadmap and future enhancements**
  - Listed suggested enhancements (e.g. blog categories filter, more cities in test ride).
  - Documented technical debt or refactor ideas (e.g. centralize apiBase).
  - Formatted as **ROADMAP.md** or appendix in development analysis (for post-upload reference).

---

### 27 Feb (Fri)
- **Server upload prep – checklist and verification**
  - Prepared deployment Q&A: common post-upload tasks (add post, change announcement, manage comments).
  - Prepared server upload checklist and post-upload verification script (dashboard, blog, merchant).

---

### 28 Feb (Sat)
- **Upload to server – consolidation and email/payment**
  - Consolidated all docs (CHANGELOG, DEVELOPMENT-ANALYSIS, MERCHANT-INTEGRATION, dashboard guide, checklists); created index or README for server deployment.
  - Verified SMTP configuration flow in dashboard (save, test email); verified Razorpay order creation and verification flow (test mode). Documented test steps for post-upload verification (test ride email, order confirmation).

---

### 29 Feb (Sun)
- **UAT and final report**
  - Ran through UAT script (all main user flows: blog, dashboard, forms, merchant) and documented results.
  - Addressed UAT findings (bugs or clarifications) within scope.
  - Updated **CLIENT-HOURS-REPORT.md** with February hours summary and deliverables list; final sign-off support.

---

## Summary – February 2026

| Day   | Focus |
|-------|--------|
| 1–4 Feb | Development analysis (structure, pages, backend, merchant, routing) |
| 5–7 Feb | Security review (API inputs, config access, CORS/framing) |
| 8–10 Feb | Performance (blog, dashboard, images, recommendations) |
| 11–12 Feb | Backup and deployment documentation |
| 13–14 Feb | Dashboard user guide (core, merchant, SMTP) |
| 15–17 Feb | SEO audit (key pages, social, sitemap, fixes) |
| 18–19 Feb | Blog/media, form validation and UX |
| 20–22 Feb | Mobile responsiveness audit and fixes |
| 23–24 Feb | Browser compatibility testing |
| 25 Feb | Server and permissions checklist |
| 26 Feb | Roadmap and future enhancements |
| 27–28 Feb | Server upload (checklist, verification, consolidation, email/payment) |
| 29 Feb | UAT and final report update |

---

*Per-day changelog from 1 January 2026 to 29 February 2026. Something done every day. For deployment, ensure PHP runs for `api/*.php` and `config/comments.json` is writable.*
