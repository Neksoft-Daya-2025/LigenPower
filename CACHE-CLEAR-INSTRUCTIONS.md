# Cache Clearing Instructions

## Problem
After uploading changes, the old hamburger menu still appears on the server.

## Solution Steps

### 1. **Clear Browser Cache**
- **Chrome/Edge**: Press `Ctrl + Shift + Delete` → Select "Cached images and files" → Clear
- **Firefox**: Press `Ctrl + Shift + Delete` → Select "Cache" → Clear
- **Or Hard Refresh**: Press `Ctrl + F5` or `Ctrl + Shift + R` on any page

### 2. **Verify Files Are Uploaded**
Make sure these files are uploaded to your server:
- ✅ `partials/header.html` (with new mobile menu structure)
- ✅ `assets/js/mobile-menu-clean.js`
- ✅ `assets/js/desktop-menu-clean.js`
- ✅ All HTML files (index.html, about-us.html, contact.html, etc.)
- ✅ `.htaccess` (with updated cache rules)

### 3. **Clear Server Cache (if using Hostinger)**
- Log into your Hostinger control panel
- Go to **Website** → **Cache** → **Clear Cache**
- Or use **File Manager** → Delete any cache folders

### 4. **Test in Incognito/Private Mode**
- Open your site in an incognito/private browser window
- This bypasses browser cache completely
- If it works here, it's definitely a cache issue

### 5. **Add Cache-Busting to Scripts (if still not working)**
If the issue persists, we can add version numbers to script URLs:
```html
<script src="assets/js/mobile-menu-clean.js?v=2.0"></script>
```

### 6. **Check File Permissions**
- Ensure all files have correct permissions (644 for files, 755 for folders)
- Check that `.htaccess` is readable

## Quick Test
1. Open your site in incognito mode
2. Check if the hamburger menu works
3. If YES → Browser cache issue (clear cache)
4. If NO → Server cache or files not uploaded correctly

## Still Not Working?
- Check browser console (F12) for JavaScript errors
- Verify the files are actually on the server (check file dates)
- Contact Hostinger support to clear server-side cache
