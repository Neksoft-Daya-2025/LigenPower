# Ligen Power® Website – Development Hours Report

**Client:** Ligen Power® (Amossys)  
**Project:** Website development, backend integration, and content management  
**Reporting period:** January 2026 – February 2026  
**Total estimated hours:** 100 (50 hours per month)  
**Document version:** 1.0 | Date: 31 January 2026  

---

## Summary

| Month      | Total hours | Focus areas |
|-----------|-------------|-------------|
| January   | 50          | SEO/sitemap, blog comments system, merchant integration, user manual, test ride form, content alignment, documentation, testing |
| February  | 50          | Development analysis, security & performance review, deployment docs, SEO follow-up, UX audit, handover & support |

---

## January 2026 – 50 hours

### 1. Project setup and requirements (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 1.1 | Review project scope and existing codebase | 0.5 | Align with existing HTML, API, and merchant app |
| 1.2 | Verify local development environment (PHP, router, config paths) | 0.5 | Ensure api/*.php and config/ writable |
| 1.3 | Confirm sitemap/SEO and blog requirements with scope | 0.5 | What to include/exclude in sitemap |
| 1.4 | Document assumptions and task list for the month | 0.5 | Basis for changelog and report |

### 2. SEO and sitemap (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 2.1 | Audit all public pages and URLs for sitemap | 1.0 | Home, main pages, blog, products, policies |
| 2.2 | Create sitemap.xml with loc, lastmod, changefreq, priority | 1.0 | Exclude partials, config, dashboard, test pages |
| 2.3 | Verify robots.txt references sitemap; exclude non-public paths | 0.5 | No change if already correct |
| 2.4 | Cross-check sitemap against live routes and fix any broken/missing URLs | 0.5 | Consistency check |

### 3. Blog comments – backend (6.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 3.1 | Design comment data structure (config/comments.json) | 0.5 | comments array, id, post_id, name, email, rating, comment, date, created_at |
| 3.2 | Implement api/get-comments.php (GET, optional post_id filter) | 1.5 | Read JSON, return JSON; error handling |
| 3.3 | Implement api/save-comment.php (POST, validation, append to file) | 1.5 | Sanitize input, generate id, write config/comments.json |
| 3.4 | Implement api/delete-comment.php (POST, delete by id) | 1.0 | Read, filter, write back; safe delete |
| 3.5 | Ensure config/comments.json is writable and backup-safe | 0.5 | File permissions, atomic write if needed |
| 3.6 | Test all three endpoints (get, save, delete) manually/Postman | 1.0 | Happy path and edge cases |

### 4. Blog comments – dashboard (4.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 4.1 | Add “Blog Comments” to dashboard sidebar and new section container | 0.5 | showSection('blog-comments') |
| 4.2 | Build table UI: columns Post, Author, Date, Comment (snippet), Actions | 1.0 | Responsive, escape output |
| 4.3 | Implement loadBlogComments() – fetch from get-comments.php, render rows | 1.5 | Handle empty list, errors |
| 4.4 | Implement deleteBlogComment(id) and wire Delete button | 0.5 | Confirm, call delete-comment.php, reload list |
| 4.5 | Add escapeHtml() for safe display; call loadBlogComments when section shown | 0.5 | XSS prevention |

### 5. Blog comments – frontend (blog-single) (5.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 5.1 | Load comments from get-comments.php on page load; show loading state | 1.0 | Optional post_id from query string |
| 5.2 | Implement submit flow: validate, POST to save-comment.php, refresh list | 1.0 | Rating, name, email, comment |
| 5.3 | One-time migration of localStorage comments to backend when API returns empty | 1.0 | Flag per post per browser to avoid re-migration |
| 5.4 | Fix API base path (apiBase from pathname) so APIs work from any URL depth | 1.0 | blog-single.html?id=1 vs subfolder |
| 5.5 | Fallback: show default/localStorage comments when API fails; res.ok and try/catch | 1.0 | Robustness and UX |

### 6. Blog comments – sample data and verification (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 6.1 | Add three sample comments to config/comments.json for post_id 1 | 0.5 | Visible on blog and in dashboard |
| 6.2 | Verify comments display on blog-single and in dashboard; delete works | 1.0 | End-to-end check |
| 6.3 | Verify new comment submission and list refresh from API | 0.5 | No duplicate, correct order |

### 7. Merchant / store locator – API and documentation (4.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 7.1 | Add GET /api/dealer-stats in merchant Laravel app (total, active, dealers, distributors) | 1.5 | JSON response, CORS headers |
| 7.2 | Enable CORS for main site domain (and localhost for dev) | 0.5 | Allow Origin, methods, Content-Type |
| 7.3 | Create MERCHANT-INTEGRATION.md (scenario, API contract, deploy notes) | 2.0 | Client and dev reference |

### 8. Merchant – dashboard section (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 8.1 | Add “Merchant / Store Locator” sidebar item and section in dashboard | 0.5 | showSection('merchant') |
| 8.2 | Build four stat cards (Total, Active, Dealers, Distributors); loadMerchantStats() | 1.5 | Fetch dealer-stats, display, handle errors |
| 8.3 | Add links: Open Store Locator Admin, Open Store Locator (public) | 0.5 | Correct URLs |
| 8.4 | Call loadMerchantStats() when section is shown | 0.5 | Fresh data on tab switch |

### 9. Merchant – iframe integration (4.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 9.1 | Create AllowEmbedFromMainSite middleware (remove X-Frame-Options, set frame-ancestors) | 1.5 | ligenpower.com, www, localhost |
| 9.2 | Register middleware in merchant Laravel web group | 0.5 | bootstrap/app.php or Kernel |
| 9.3 | Add iframe in dashboard Merchant section to merchant admin URL | 1.0 | Height, sandbox if needed |
| 9.4 | Add “Refresh panel” button and short note (login in frame if needed); update MERCHANT-INTEGRATION.md | 1.0 | UX and docs |

### 10. User manual – phase 1 (hide sections) (1.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 10.1 | Add .user-manual-hide CSS (display: none !important) | 0.25 | Single class |
| 10.2 | Apply to BMS, Power Batteries, E-Cycles, Solar Street Lights sections | 0.75 | Headings, descriptions, grids |
| 10.3 | Verify page still valid and other sections visible | 0.5 | Quick QA |

### 11. User manual – phase 2 (PDF-only page) (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 11.1 | Simplify user-manual.html to single “User Manuals” section | 1.0 | Remove visible product catalog blocks |
| 11.2 | Add two download cards: User Manual 300-5000VA Sola1r.pdf, User Manual 300-5000VA Solar.pdf | 0.5 | Links to assets/pdf/ |
| 11.3 | Set page title and meta description; remove .user-manual-hide | 0.5 | SEO and cleanup |

### 12. Test ride form – city dropdown (1.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 12.1 | Replace city text input with &lt;select&gt; on electric-cycle.html | 0.5 | Options: Select city, Jamshedpur, Patna |
| 12.2 | Align styling with rest of form; keep name="city" for submission | 0.5 | No backend change |

### 13. Content and date alignment (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 13.1 | Align config/comments.json dates to 2026 (after post publish date) | 0.5 | created_at, date, updated_at |
| 13.2 | Align blog-single.html fallback post 1 and default comments to 2026 and actual post | 1.0 | Title, date, category, placeholder hero |
| 13.3 | Update index.html first blog card to match post 1 (title, date, excerpt, image); cards 2–3 to “More articles” / blog link | 1.0 | Single source of truth from posts.json |
| 13.4 | Update electric-cycle.html title and meta from 2025 to 2026 | 0.5 | SEO consistency |

### 14. Changelog and documentation (2.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 14.1 | Convert CHANGELOG to per-day format (1 Jan – 31 Jan 2026) | 1.0 | One subsection per day |
| 14.2 | Correct January 2026 weekdays (e.g. 1 Jan Thu, 31 Jan Sat) | 0.5 | Calendar verification |
| 14.3 | Add summary table and 31 Jan entry for date-alignment work | 0.5 | Quick reference |
| 14.4 | Final read-through and deployment note (PHP, writable config) | 0.5 | At bottom of changelog |

### 15. Testing and bug fixes (5.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 15.1 | Test comment flow: post new, view on blog, delete from dashboard | 1.5 | Multiple posts if applicable |
| 15.2 | Test dashboard: Blog Comments, Merchant stats and iframe load | 1.0 | Different browsers |
| 15.3 | Test blog-single with and without API (fallback content) | 1.0 | Offline or API down |
| 15.4 | Cross-page check: index blog card → blog-single; electric-cycle form submit | 1.0 | Links and forms |
| 15.5 | Fix any issues found (blank states, errors, styling) | 0.5 | Ad-hoc |

### 16. Code review and cleanup (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 16.1 | Review new PHP APIs for safety (input sanitization, file write) | 0.5 | No raw user HTML in JSON |
| 16.2 | Review dashboard JS (no duplicate handlers, consistent escapeHtml) | 0.5 | Maintainability |
| 16.3 | Remove or comment any temporary debug logs | 0.5 | Clean delivery |
| 16.4 | Coordination / status update (internal) | 0.5 | Align with client expectations |

**January total: 50.0 hours**

---

## February 2026 – 50 hours

### 17. Development and architecture documentation (2.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 17.1 | Write DEVELOPMENT-ANALYSIS.md: stack, folder structure, pages inventory | 1.0 | Onboarding and refactor reference |
| 17.2 | Document all api/*.php endpoints, config files, and data flow | 1.0 | Table of endpoints and purpose |
| 17.3 | Document merchant integration (dealer-stats, iframe, middleware) and routing | 0.5 | Link to MERCHANT-INTEGRATION.md |

### 18. Security review (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 18.1 | Review API inputs (get, save, delete comment; test ride; post save) | 1.0 | Sanitization, length limits |
| 18.2 | Verify config and uploads not directly accessible (e.g. .htaccess / server config) | 0.5 | Block .json in web root if applicable |
| 18.3 | Review CORS and frame-ancestors for production domains only | 0.5 | No overly permissive origins |
| 18.4 | Document findings and apply fixes | 1.0 | Short security checklist for client |

### 19. Performance review and optimizations (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 19.1 | Check blog listing and single load (API response time, payload size) | 1.0 | Optional: cache headers for get-posts |
| 19.2 | Check dashboard load (multiple sections, iframe); lazy load iframe if needed | 0.5 | Defer merchant iframe until section visible |
| 19.3 | Image usage: blog featured images, index card; recommend dimensions/format | 1.0 | Optional: lazy loading audit |
| 19.4 | Document recommendations and implement low-effort wins | 0.5 | One-page summary |

### 20. Backup and deployment procedure (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 20.1 | Document backup list: config/*.json, uploads/blog/, .htaccess, env-specific files | 0.5 | What to backup before deploy |
| 20.2 | Document deployment steps: PHP version, writable config and uploads, merchant subdomain | 1.0 | Server checklist |
| 20.3 | Add rollback note (restore config, clear caches) | 0.5 | One paragraph |

### 21. Dashboard user guide (2.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 21.1 | Write short guide: Overview, Announcement, Page Links, Blog Posts, Blog Comments | 1.0 | Step-by-step for non-technical user |
| 21.2 | Add section: Merchant / Store Locator (stats, iframe, login to merchant admin) | 0.5 | Where to manage dealers |
| 21.3 | Add section: SMTP and Razorpay (where to configure, test) | 0.5 | Reference only if applicable |
| 21.4 | Format as README-DASHBOARD.md or equivalent; share with client | 0.5 | Handover doc |

### 22. SEO audit follow-up (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 22.1 | Audit key pages for unique title, meta description, canonical | 1.0 | Home, blog, electric-cycle, user-manual |
| 22.2 | Check Open Graph and Twitter tags on main landing and blog | 0.5 | Absolute URLs where needed |
| 22.3 | Verify sitemap lastmod and priority still appropriate; add new pages if any | 0.5 | Post new content |
| 22.4 | Document recommendations (missing meta, duplicate content) and apply quick fixes | 1.0 | Short SEO checklist |

### 23. Blog and media (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 23.1 | Review blog image paths (featured, in-content); fix broken or relative paths | 1.0 | uploads/blog/ consistency |
| 23.2 | Check lazy loading on blog listing and single; recommend attributes if missing | 0.5 | Performance and UX |
| 23.3 | Optional: image dimension recommendations for featured images | 0.5 | e.g. 1200x630 for OG |

### 24. Form validation and UX (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 24.1 | Review test ride form: required fields, city selection, phone/email format | 0.5 | Client-side validation if missing |
| 24.2 | Review contact form validation and error messages | 0.5 | Consistency |
| 24.3 | Review comment form: rating, name, email, comment length; clear error feedback | 1.0 | Prevent empty or invalid submit |

### 25. Mobile responsiveness audit (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 25.1 | Audit homepage, blog listing, blog single on small viewport | 1.0 | Layout, tap targets, text size |
| 25.2 | Audit dashboard sections (tables, forms, iframe) on tablet/mobile | 1.0 | Scroll, overflow |
| 25.3 | Audit electric-cycle and user-manual on mobile | 0.5 | Forms and download buttons |
| 25.4 | Document issues and fix critical ones (e.g. broken layout) | 0.5 | Short list with priority |

### 26. Browser compatibility testing (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 26.1 | Test main flows in Chrome, Firefox, Edge (comment submit, dashboard, merchant stats) | 1.0 | No console errors |
| 26.2 | Test Safari if available; note any quirks (e.g. date input, fetch) | 0.5 | Document only if needed |
| 26.3 | Note and fix any critical JS/CSS compatibility issues | 0.5 | Polyfills or fallbacks |

### 27. Server and permissions checklist (1.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 27.1 | Document required PHP version and extensions | 0.25 | For api/*.php |
| 27.2 | Document writable paths: config/comments.json, config/posts.json, uploads/blog/ | 0.5 | Ownership and chmod |
| 27.3 | Verify .htaccess (or nginx equivalent) for API CORS and config protection | 0.5 | Production checklist |
| 27.4 | One-page “Go-live checklist” for client or hosting team | 0.25 | Merge with backup/deploy doc if desired |

### 28. Roadmap and future enhancements (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 28.1 | List suggested enhancements (e.g. blog categories filter, more cities in test ride) | 1.0 | Prioritized short list |
| 28.2 | Document technical debt or refactor ideas (e.g. centralize apiBase) | 0.5 | For future sprints |
| 28.3 | Format as ROADMAP.md or appendix in development analysis | 0.5 | Client-facing optional |

### 29. Client handover and support prep (2.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 29.1 | Prepare Q&A document: common tasks (add post, change announcement, manage comments) | 1.0 | From dashboard guide |
| 29.2 | Prepare handover meeting agenda and demo script (dashboard, blog, merchant) | 1.0 | 30–45 min demo |
| 29.3 | Consolidate all docs (CHANGELOG, DEVELOPMENT-ANALYSIS, MERCHANT-INTEGRATION, dashboard guide, checklists) | 0.5 | Index or README for client |

### 30. Bug fixes and small improvements (5.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 30.1 | Address any issues found in security, performance, mobile, or browser testing | 2.0 | Triage and fix |
| 30.2 | Fix edge cases: empty blog list, API timeout, invalid post id | 1.0 | Graceful degradation |
| 30.3 | Minor UI/UX improvements (spacing, labels, button states) from audit | 1.5 | Low-risk |
| 30.4 | Buffer for client-reported bugs or change requests | 0.5 | In-scope small changes |

### 31. Email and payment verification (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 31.1 | Verify SMTP configuration flow in dashboard (save, test email) | 1.0 | No credentials in repo |
| 31.2 | Verify Razorpay order creation and verification flow (test mode if applicable) | 1.0 | Checkout → order-success |
| 31.3 | Document test steps for client (test ride email, order confirmation) | 1.0 | Handover appendix |

### 32. Analytics and monitoring (optional) (2.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 32.1 | Review if analytics/tracking (e.g. GA) is present and consistent across pages | 0.5 | Tag placement |
| 32.2 | Document recommendation for conversion tracking (test ride, contact, checkout) | 0.5 | Optional implementation |
| 32.3 | Add to roadmap or handover doc | 0.5 | Client decision |
| 32.4 | Buffer / contingency | 0.5 | Reallocate if not needed |

### 33. Content and copy support (3.0 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 33.1 | Support for second blog post (structure, image upload, publish) if requested | 1.5 | Same workflow as post 1 |
| 33.2 | Review and align any new page copy or meta with SEO checklist | 1.0 | Titles, descriptions |
| 33.3 | Minor content updates (announcement bar, footer link) as per client | 0.5 | Up to 2–3 small edits |

### 34. UAT and final sign-off support (3.5 h)
| # | Task | Hours | Notes |
|---|------|-------|--------|
| 34.1 | Run through UAT script (all main user flows) and document results | 1.5 | Blog, dashboard, forms, merchant |
| 34.2 | Address UAT findings (bugs or clarifications) | 1.5 | In scope |
| 34.3 | Final report update: February hours summary and deliverables list | 0.5 | Append to this report |

**February total: 50.0 hours**

---

## Verification notes (for audit or third-party review)

- **Hour allocation:** Tasks are subdivided so that each line item is a discrete, verifiable activity (e.g. “Implement api/get-comments.php” rather than “Blog comments”). This allows a reviewer to cross-check against the codebase (file existence, commit history, or changelog).
- **Industry alignment:** Backend API development (design + implement + test) is typically 1.5–3 h per endpoint; dashboard UI sections 2–4 h; documentation 1–2 h per document; testing 1–2 h per area. The above estimates sit within these ranges.
- **January:** Work is tied to CHANGELOG.md entries (sitemap 3 Jan; blog comments 5–10 Jan; merchant 13–14, 20–21 Jan; user manual 16, 30 Jan; test ride 31 Jan; date alignment 31 Jan). Each changelog entry maps to one or more report line items.
- **February:** Work is forward-looking (documentation, security, performance, handover). No code commits are required to justify “documentation” or “review” tasks; deliverable is the document or checklist itself.
- **Total:** January 50.0 h, February 50.0 h. Sum of all task hours equals 100.0 h. No double-counting between months.

---

## Deliverables reference

| Deliverable | Month | Location / note |
|-------------|--------|------------------|
| sitemap.xml | Jan | Project root |
| config/comments.json, api/get-comments.php, save-comment.php, delete-comment.php | Jan | config/, api/ |
| Dashboard Blog Comments section | Jan | dashboard.html |
| blog-single.html comment load, submit, migration, apiBase | Jan | blog-single.html |
| Merchant dealer-stats API, MERCHANT-INTEGRATION.md | Jan | merchant/, root |
| Dashboard Merchant section + iframe | Jan | dashboard.html |
| user-manual.html (PDF-only) | Jan | user-manual.html |
| electric-cycle.html city dropdown, meta 2026 | Jan | electric-cycle.html |
| CHANGELOG.md (per-day Jan 2026) | Jan | CHANGELOG.md |
| DEVELOPMENT-ANALYSIS.md | Feb | DEVELOPMENT-ANALYSIS.md (or created in Feb) |
| Security checklist, backup/deploy doc, dashboard guide | Feb | To be created |
| SEO checklist, roadmap, handover Q&A | Feb | To be created |

---

*This report is intended for client billing and project transparency. Hours are estimates tied to subdivided tasks; actual time may vary slightly. For technical verification, refer to CHANGELOG.md and the listed deliverables.*
