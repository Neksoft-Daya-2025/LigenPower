# Ligen Power Website

Ligen Power's public website and lightweight content-management dashboard. The project uses static HTML/CSS/JavaScript for the storefront and PHP/JSON endpoints for dynamic products, datasheets, news, events, FAQs, enquiries, and blog content.

## Requirements

- PHP 8.1 or newer
- A modern web browser
- Write permission for the `config/` and `uploads/` directories

## Run Locally

From the project root, start PHP's development server:

```bash
php -S 127.0.0.1:8000 router.php
```

Then open:

- Website: `http://localhost:8000/`
- Admin dashboard: `http://localhost:8000/dashboard.html`
- FAQ page: `http://localhost:8000/faq.html`
- News & Events: `http://localhost:8000/news-events.html`
- Datasheets: `http://localhost:8000/datasheet.html`

Do not open the HTML files directly from the filesystem. Dynamic API requests and shared header/footer components require the PHP server.

## Admin Modules

The dashboard provides the following management areas:

- Products with category/subcategory segregation and modal-based editing
- PDF datasheet upload and publishing
- News and event publishing with featured images
- FAQ creation, categorization, ordering, search, and draft/published status
- Blog, comments, enquiries, orders, links, SMTP, and announcement management
- Merchant and pincode management through their dedicated external portals

Dashboard navigation uses URL hashes, so refreshing a section such as `dashboard.html#faqs` keeps that section open.

## Dynamic Content

| Module | Public page | API | Data file |
| --- | --- | --- | --- |
| Datasheets | `datasheet.html` | `api/manage-datasheets.php` | `config/datasheets.json` |
| News & Events | `news-events.html` | `api/manage-news-events.php` | `config/news-events.json` |
| FAQs | `faq.html` | `api/manage-faqs.php` | `config/faqs.json` |
| Blog | `blog.html` | Blog API files in `api/` | `config/posts.json` |

Uploaded files are validated by their corresponding PHP endpoint and stored under `uploads/`.

## Product Catalogue

The primary catalogue includes power inverters, solar inverters, LFP batteries, battery-management systems, solar street lights, and accessories. Legacy EV-cycle navigation and catalogue entries have been retired; the former EV-cycle route redirects to the LFP battery section.

## Project Structure

```text
.
|-- api/                 PHP API endpoints
|-- assets/              CSS, JavaScript, fonts, and images
|-- config/              JSON content stores and application configuration
|-- partials/            Shared header and footer markup
|-- uploads/             Uploaded PDFs and images
|-- dashboard.html       Administration dashboard
|-- index.html           Homepage
|-- faq.html             Dynamic FAQ page
|-- news-events.html     Dynamic news and events page
|-- datasheet.html       Dynamic datasheet library
`-- router.php           Local clean-URL router
```

## Content Publishing Notes

- Use PDF files for datasheets.
- Use JPG, PNG, or WebP images for news and events (maximum 5 MB).
- Draft content remains available in the dashboard but is excluded from public pages.
- Avoid committing passwords, API keys, SMTP credentials, or other secrets.

## Validation

Before committing changes, run:

```bash
php -l router.php
php -l api/manage-datasheets.php
php -l api/manage-news-events.php
php -l api/manage-faqs.php
node --check assets/js/search.js
node --check assets/js/chatbot.js
git diff --check
```

Also verify the main public pages and dashboard modules on localhost.
