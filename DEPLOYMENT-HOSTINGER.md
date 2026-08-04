# 🚀 Deployment Guide for Hostinger Shared Hosting

## ✅ Yes, This Will Work on Hostinger!

Your website is designed to work perfectly on Hostinger shared hosting. Here's what you need to know:

## 📋 What Works on Hostinger

✅ **PHP Support** - Hostinger supports PHP (usually PHP 7.4+ or 8.x)  
✅ **File System** - JSON file storage works perfectly  
✅ **SMTP Email** - Your configured SMTP will work  
✅ **No Database Required** - Everything uses file-based storage  
✅ **Static Files** - All HTML, CSS, JS files work as-is  

## 📁 File Structure on Hostinger

Upload your files to Hostinger's `public_html` directory:

```
public_html/
├── index.html
├── dashboard.html
├── api/
│   ├── get-smtp-config.php
│   ├── save-smtp-config.php
│   ├── send-email.php
│   └── ... (all other PHP files)
├── config/
│   ├── smtp-config.json
│   ├── announcement.json
│   └── page-links.json
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
└── partials/
    ├── header.html
    └── footer.html
```

## 🔧 Important Setup Steps

### 1. Create Config Directory

The `config/` directory must exist and be **writable**:

**Via cPanel File Manager:**
1. Go to File Manager
2. Navigate to `public_html`
3. Create folder: `config`
4. Right-click → Change Permissions → Set to `755` or `777`

**Via FTP:**
```bash
mkdir config
chmod 755 config
```

### 2. Set File Permissions

Make sure these files/directories are writable:

- `config/` directory: **755** or **777**
- `config/smtp-config.json`: **644** or **666**
- `config/announcement.json`: **644** or **666**
- `config/page-links.json`: **644** or **666**

### 3. PHP Version

Check your PHP version in cPanel:
- Go to **Select PHP Version**
- Choose **PHP 8.0** or higher (recommended)
- Make sure these extensions are enabled:
  - ✅ `php_openssl` (for SMTP)
  - ✅ `php_curl` (if needed)
  - ✅ `php_json` (usually built-in)

### 4. SMTP Configuration

Your SMTP settings are already configured:
- **Host:** smtp.hostinger.com
- **Port:** 465
- **Encryption:** SSL
- **Username:** info@clasmentor.in

These will work perfectly on Hostinger!

## 🚫 What You DON'T Need

❌ **No Database Setup** - Everything uses JSON files  
❌ **No PHP Server Command** - Hostinger handles PHP automatically  
❌ **No Special Configuration** - Just upload and set permissions  

## 📤 Upload Process

### Option 1: Via cPanel File Manager
1. Login to Hostinger cPanel
2. Open **File Manager**
3. Go to `public_html`
4. Upload all files maintaining the folder structure

### Option 2: Via FTP
1. Use FTP client (FileZilla, WinSCP, etc.)
2. Connect to your Hostinger FTP
3. Upload to `public_html` directory
4. Maintain folder structure

### Option 3: Via ZIP Upload
1. Zip all files (maintaining structure)
2. Upload ZIP to `public_html`
3. Extract in cPanel File Manager

## ✅ Post-Deployment Checklist

After uploading:

1. ✅ Check `config/` directory exists and is writable
2. ✅ Visit: `https://yourdomain.com/dashboard.html`
3. ✅ Go to SMTP Settings - verify config loads
4. ✅ Test email sending from dashboard
5. ✅ Check website forms work (quote requests, contact forms)
6. ✅ Verify announcements display correctly

## 🔍 Troubleshooting

### Issue: "Permission denied" errors
**Solution:** Set `config/` directory permissions to 755 or 777

### Issue: SMTP not saving
**Solution:** Check `config/` directory is writable (chmod 755)

### Issue: Email not sending
**Solution:** 
- Verify SMTP credentials in dashboard
- Check PHP `openssl` extension is enabled
- Test with "Send Test Email" in dashboard

### Issue: API endpoints return 404
**Solution:** Make sure all files in `api/` folder are uploaded

## 🌐 Access URLs

After deployment:
- **Website:** `https://yourdomain.com/`
- **Dashboard:** `https://yourdomain.com/dashboard.html`
- **API:** `https://yourdomain.com/api/get-smtp-config.php`

## 📝 Notes

1. **HTTPS:** Hostinger usually provides free SSL - make sure it's enabled
2. **PHP Version:** Use PHP 8.0+ for best compatibility
3. **File Permissions:** `config/` must be writable for saving settings
4. **No .htaccess Needed:** Your current setup works without special rules

## 🎯 Summary

✅ **Works perfectly on Hostinger shared hosting**  
✅ **No database required**  
✅ **Just upload files and set permissions**  
✅ **Your SMTP is already configured**  
✅ **Everything is ready to go!**

---

**Need Help?** Check Hostinger's documentation or contact their support for:
- Setting file permissions
- PHP version selection
- SSL certificate setup

