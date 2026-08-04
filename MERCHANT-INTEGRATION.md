# Merchant / Store Locator – Backend Integration

## Scenario

- **Store locator** is hosted on the subdomain **merchant.ligenpower.com** (Laravel app in `/merchant`).
- **Main site** is **ligenpower.com** (this project: static HTML + PHP APIs, dashboard at `dashboard.html`).
- The main site’s **Store Locator** link (header, page links) points to `https://merchant.ligenpower.com/`.

The **Merchant backend is incorporated into the main site’s dashboard** via a **Merchant / Store Locator** section. Dealers are still managed only in the merchant app; the main dashboard shows stats and quick links so you can manage everything from one place.

---

## What Was Done

### 1. Merchant app (merchant.ligenpower.com)

- **Public read-only APIs** added in `merchant/routes/web.php`:
  - **GET** `https://merchant.ligenpower.com/api/dealer-stats`
  - Returns JSON: `total`, `active`, `dealers`, `distributors` (counts).
  - **GET** `https://merchant.ligenpower.com/api/dealers-by-pincode?pincode=800001`
  - Returns JSON: `success`, `dealers` (array of dealer/distributor objects). Used by checkout to show nearest dealers when user enters pincode.
  - **GET** `https://merchant.ligenpower.com/api/pincode-lookup?pincode=800001`
  - Returns JSON: `success`, `serviceable`, `city`, `state`, `district`. Used by checkout to auto-fill city/state from pincode (when managed in admin).
  - CORS headers allow the main site (or any origin) to call them.

- **Allow embedding in iframe** from the main site and localhost:
  - New middleware **`App\Http\Middleware\AllowEmbedFromMainSite`**: removes `X-Frame-Options` and sets `Content-Security-Policy: frame-ancestors` so the merchant admin can be embedded in pages on `https://ligenpower.com`, `http://localhost:8000`, etc.
  - Registered in `merchant/bootstrap/app.php` (appended to the `web` middleware group).

The store locator (home, search by state/district) and **admin** (login, CRUD dealers, states, districts, CSV import/export) work as before; the admin can now also be used inside the main dashboard iframe.

### 2. Main site dashboard (dashboard.html)

- New sidebar item: **Merchant / Store Locator**.
- New section:
  - Short description: manage dealers, states, districts, and CSV import/export from this dashboard.
  - **Stats** loaded from `https://merchant.ligenpower.com/api/dealer-stats` when you open the section: Total, Active, Dealers, Distributors.
  - **Embedded admin panel**: an **iframe** loads `https://merchant.ligenpower.com/admin` so you can add/edit/delete dealers, manage states and districts, and use CSV import/export without leaving the dashboard. If you see the login page in the frame, sign in once there; then all functionality is available in the panel.
  - **Refresh panel** button to reload the iframe.
  - **Open Store Locator Admin** (new tab) and **Open Store Locator (public)** (new tab) links.

So: one dashboard (main site) with a **Merchant section** that shows live dealer counts and the **full merchant admin embedded**, so things can be uploaded and managed from here. All data still lives in the merchant backend.

---

## How It Works

| Where | What |
|-------|------|
| **Main site (ligenpower.com)** | Dashboard has “Merchant / Store Locator” section: stats + links. Header/footer “Store Locator” link goes to merchant subdomain. |
| **Merchant (merchant.ligenpower.com)** | Public store locator (search by state/district). Admin at `/admin` for dealers, states, districts, **pincodes by city**. APIs: dealer-stats, dealers-by-pincode, pincode-lookup. |
| **Data** | Dealers live only in the merchant app’s database. Main site does not store dealers; it only displays stats from the API and links to merchant. |

---

## Making Sure Everything Works

1. **Merchant subdomain**
   - Deploy and run the merchant Laravel app at **merchant.ligenpower.com** (same codebase as in `/merchant`).
   - Ensure the new route is loaded: `GET /api/dealer-stats` must be reachable (no auth).

2. **Main site**
   - Deploy `dashboard.html` (and the rest of the main site) as usual.
   - Dashboard is used at e.g. `https://ligenpower.com/dashboard.html` (or your actual URL).

3. **Stats in dashboard**
   - When you open the “Merchant / Store Locator” section, the dashboard calls `https://merchant.ligenpower.com/api/dealer-stats`.
   - If the merchant app is down or CORS/network blocks the request, the stats show “?” and the two links still work.

4. **Store locator**
   - Public: **merchant.ligenpower.com** (unchanged).
   - Admin: **merchant.ligenpower.com/admin** (login, then manage dealers/states/districts).
   - Main site “Store Locator” in header/page links should point to `https://merchant.ligenpower.com/` (already set in `partials/header.html` and `api/manage-links.php`).

5. **No duplicate backend**
   - Dealer CRUD is only in the merchant app. The main site does not have its own dealer database or admin; it only shows stats and links. So there is a single backend for store locator (the merchant app), incorporated into the main backend only as a **section + API stats**.

---

## Optional: Restrict CORS

If you want the dealer-stats API to be callable only from your main site, in `merchant/routes/web.php` change the CORS header from:

```php
header('Access-Control-Allow-Origin: *');
```

to:

```php
header('Access-Control-Allow-Origin: https://ligenpower.com');
```

(Add `http://localhost:8000` or your staging URL if you test the main dashboard locally.)

---

## File Changes Summary

| File | Change |
|------|--------|
| `merchant/routes/web.php` | Added `GET /api/dealer-stats` and `GET /api/dealers-by-pincode?pincode=...` returning JSON with CORS. |
| `checkout.html` | Pincode step calls dealers-by-pincode and pincode-lookup APIs; shows nearest dealers if any; auto-fills city/state from pincode when available; continues to checkout form. |
| `merchant/.../PincodeController.php` | CRUD for pincodes (pincode, city, state, district, is_serviceable). Import/export CSV. |
| `merchant/.../create_pincodes_table.php` | Migration for `pincodes` table. |
| `merchant/app/Http/Middleware/AllowEmbedFromMainSite.php` | New middleware: allow iframe embedding from ligenpower.com and localhost. |
| `merchant/bootstrap/app.php` | Append `AllowEmbedFromMainSite` to the `web` middleware group. |
| `dashboard.html` | Added “Merchant / Store Locator” sidebar item; section with stats, embedded iframe (merchant admin), Refresh button, and links to open admin/public in new tab; `loadMerchantStats()` when section is shown. |

No changes were made to merchant admin logic, store locator search, or main site header/footer links; they continue to work as before. The admin is now also usable inside the dashboard via the iframe.
