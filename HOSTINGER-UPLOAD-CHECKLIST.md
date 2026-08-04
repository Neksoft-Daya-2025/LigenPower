# Hostinger Upload Checklist - Hamburger Menu Fix

## ✅ Files That MUST Be Uploaded

### 1. **JavaScript Files** (CRITICAL)
- ✅ `assets/js/header-loader.js` (UPDATED - simplified, no old Elementor code)
- ✅ `assets/js/mobile-menu-clean.js` (Menu handler)
- ✅ `assets/js/desktop-menu-clean.js` (Desktop menu handler)

### 2. **Header File** (CRITICAL)
- ✅ `partials/header.html` (Contains the clean mobile menu structure)

### 3. **All HTML Pages** (IMPORTANT)
All HTML files that load the header need to include the menu scripts:
- ✅ `index.html`
- ✅ `about-us.html`
- ✅ `contact.html`
- ✅ `blog.html`
- ✅ `power-inverter.html`
- ✅ `bms.html`
- ✅ `solar-inverter.html`
- ✅ `electric-cycle.html`
- ✅ `solar-street-light.html`
- ✅ `news-events.html`
- ✅ `power-battery.html`
- ✅ `certificates.html`
- ✅ `datasheet.html`
- ✅ `user-manual.html`
- ✅ All other HTML files (35+ files)

### 4. **Server Configuration** (IMPORTANT)
- ✅ `.htaccess` (Updated with cache-busting rules)

## 🔍 Verification Steps

### Step 1: Check Files Are Uploaded
1. Log into Hostinger File Manager
2. Navigate to your website root
3. Verify these files exist and have recent timestamps:
   - `assets/js/header-loader.js`
   - `assets/js/mobile-menu-clean.js`
   - `assets/js/desktop-menu-clean.js`
   - `partials/header.html`
   - `.htaccess`

### Step 2: Check File Contents (Quick Test)
1. Open `assets/js/header-loader.js` in File Manager
2. Search for: `headerLoaded event dispatched`
3. If you find it, the file is updated ✅
4. If you see old Elementor code (`.elementor-element-780ca1f`), the file is OLD ❌

### Step 3: Clear All Caches

#### A. Hostinger Cache
1. Log into Hostinger Control Panel
2. Go to **Website** → **Cache**
3. Click **Clear Cache** or **Purge Cache**
4. Wait 2-3 minutes

#### B. Browser Cache
1. Open your site in **Incognito/Private Mode**
2. Or press `Ctrl + Shift + Delete` → Clear cache
3. Or hard refresh: `Ctrl + F5`

#### C. CDN Cache (if using)
- If you have Cloudflare or other CDN, purge its cache too

### Step 4: Test in Incognito Mode
1. Open your site in incognito/private browser window
2. Resize to mobile view
3. Check if hamburger menu appears
4. If YES → Cache issue (clear browser cache)
5. If NO → Files not uploaded correctly

## 🚨 Common Issues & Fixes

### Issue 1: "Menu button not visible"
**Cause:** CSS hiding the button
**Fix:** 
- Check `.htaccess` is uploaded
- Clear Hostinger cache
- Check browser console for CSS errors

### Issue 2: "Menu button visible but not clickable"
**Cause:** JavaScript not loading
**Fix:**
- Verify `mobile-menu-clean.js` is uploaded
- Check browser console (F12) for JavaScript errors
- Check file permissions (should be 644)

### Issue 3: "Old menu still showing"
**Cause:** Old files cached
**Fix:**
- Clear Hostinger cache
- Clear browser cache
- Upload files again with fresh timestamps

### Issue 4: "Menu works on some pages but not others"
**Cause:** Not all HTML files updated
**Fix:**
- Upload ALL HTML files
- Check that all pages include the menu scripts

## 📋 Quick Upload Command (if using FTP/SFTP)

```bash
# Upload critical files
upload assets/js/header-loader.js
upload assets/js/mobile-menu-clean.js
upload assets/js/desktop-menu-clean.js
upload partials/header.html
upload .htaccess

# Upload all HTML files
upload *.html
```

## 🔧 File Permissions Check

Files should have these permissions:
- **Files:** 644 (rw-r--r--)
- **Folders:** 755 (rwxr-xr-x)

## 🎯 Final Test Checklist

After uploading, test:
- [ ] Open site in incognito mode
- [ ] Resize to mobile view (< 1024px width)
- [ ] Hamburger menu button visible (top right)
- [ ] Click button → menu slides in from right
- [ ] Menu items are clickable
- [ ] Close button works
- [ ] Click outside menu → menu closes
- [ ] Press Escape key → menu closes

## 📞 Still Not Working?

1. **Check Browser Console (F12)**
   - Look for JavaScript errors
   - Check if files are loading (Network tab)
   - Look for console messages from mobile-menu-clean.js

2. **Verify File Paths**
   - Make sure file paths are correct
   - Check if using subdirectory (e.g., `/public_html/`)

3. **Check Server Logs**
   - Hostinger error logs
   - PHP error logs (if any)

4. **Test File Directly**
   - Try accessing: `https://yoursite.com/assets/js/mobile-menu-clean.js`
   - Should see JavaScript code, not 404 error

## ✅ Success Indicators

When it's working, you'll see in browser console:
```
✅ Header loaded, headerLoaded event dispatched
📱 Mobile menu script loaded, starting initialization...
✅ Both menu elements found - initializing...
✅ Clean mobile menu initialized successfully
```

---

**Remember:** Always test in incognito mode first to bypass browser cache!
