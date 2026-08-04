# Ligen Laravel

Laravel version of the Ligen Power® / LIgen AMossys website. All HTML pages, assets, and APIs are migrated here.

## Prerequisites

- PHP 8.2+
- Composer
- (Optional) Node.js for frontend assets

## Setup

### 1. Create the Laravel project (run when you have internet)

From the **parent folder** (e.g. your Desktop or the folder that contains `Ligen-Laravel`), run:

```bash
composer create-project laravel/laravel Ligen-Laravel-temp
```

Then move the contents of `Ligen-Laravel-temp` into `Ligen-Laravel` and remove the temp folder:

**Windows (PowerShell):**
```powershell
Move-Item -Path .\Ligen-Laravel-temp\* -Destination .\Ligen-Laravel\ -Force
Remove-Item -Path .\Ligen-Laravel-temp -Recurse -Force
```

**Or:** If `Ligen-Laravel` is empty, you can run from inside it:
```bash
cd Ligen-Laravel
composer create-project laravel/laravel . --no-install
# Then: composer install
```

### 2. Apply Ligen customizations

Copy the contents of the `APPLY-AFTER-LARAVEL` folder **into** your Laravel project root (merge with existing folders):

- `APPLY-AFTER-LARAVEL/routes/web.php` → replace `routes/web.php`
- `APPLY-AFTER-LARAVEL/app/Http/Controllers/*` → copy into `app/Http/Controllers/`
- `APPLY-AFTER-LARAVEL/resources/views/*` → merge into `resources/views/`

### 3. Copy assets and uploads from the original site

From the **LIgen AMossys** project folder (parent of `Ligen-Laravel`):

- Copy **assets/** → **Ligen-Laravel/public/assets/**
- Copy **uploads/** → **Ligen-Laravel/public/uploads/** (so blog images at `/uploads/blog/...` work)
- Copy **config/posts.json** → **Ligen-Laravel/storage/app/posts.json**
- Copy **config/announcement.json** → **Ligen-Laravel/storage/app/announcement.json** (for the top-bar announcement API)

### 4. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Set `APP_URL` in `.env` (e.g. `APP_URL=http://localhost:8000`).

### 5. Run the app

```bash
php artisan serve
```

Open http://localhost:8000

## Routes

- `/` — Home
- `/about-us`, `/blog`, `/contact`, `/electric-cycle`, `/career`, etc. — Same paths as the original HTML (without `.html`)
- `/blog` — Blog listing
- `/blog/{slug}` — Single blog post
- `/api/posts`, `/api/posts/{id}`, etc. — Blog API (see `APPLY-AFTER-LARAVEL` routes)

## Converting remaining HTML pages

Each original `.html` file (e.g. `about-us.html`) becomes a Blade view under `resources/views/pages/` (e.g. `about-us.blade.php`). The view should:

1. `@extends('layouts.app')`
2. `@section('content')` with the **main content only** (the part that was between header and footer).

The layout already includes the header and footer. You can copy the inner content from each HTML file into the corresponding `pages/{slug}.blade.php`.

## Project structure (after apply)

- `app/Http/Controllers/PageController.php` — Serves static pages by slug
- `app/Http/Controllers/BlogController.php` — Blog listing and single post
- `resources/views/layouts/app.blade.php` — Main layout (header + @yield('content') + footer)
- `resources/views/partials/header.blade.php` — Top bar and nav (uses `url()`, `asset()`)
- `resources/views/partials/footer.blade.php` — Footer (uses `url()`, `asset()`)
- `resources/views/pages/` — One Blade file per page (e.g. `index.blade.php`, `about-us.blade.php`)
- `storage/app/posts.json` — Blog posts (same format as original)
