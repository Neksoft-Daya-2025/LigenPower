# 🚀 Hostinger Update Checklist - Test Ride Requests Feature

## 📋 What Needs to Be Updated on Hostinger

### ✅ **NEW Files to Upload**

1. **API Endpoint** (CRITICAL)
   - ✅ `api/test-ride-requests.php` - **NEW FILE** - Handles saving and retrieving test ride requests

### ✅ **UPDATED Files to Upload**

2. **Frontend Pages**
   - ✅ `electric-cycle.html` - **UPDATED** - Form now submits to backend API
   - ✅ `dashboard.html` - **UPDATED** - New "Test Ride Requests" section added

### ✅ **Config Directory** (IMPORTANT)

3. **Config Files**
   - ✅ `config/test-ride-requests.json` - **Will be auto-created** - Stores all test ride requests
   - Make sure `config/` directory has **write permissions (755 or 777)**

---

## 📤 Step-by-Step Upload Instructions

### **Step 1: Upload New API File**

**Via cPanel File Manager:**
1. Login to Hostinger cPanel
2. Open **File Manager**
3. Navigate to `public_html/api/`
4. Upload: `api/test-ride-requests.php`
5. Set permissions to **644**

**Via FTP:**
```bash
# Upload the new API file
upload api/test-ride-requests.php
chmod 644 api/test-ride-requests.php
```

### **Step 2: Upload Updated HTML Files**

**Via cPanel File Manager:**
1. Navigate to `public_html/`
2. Upload (overwrite): `electric-cycle.html`
3. Upload (overwrite): `dashboard.html`
4. Set permissions to **644**

**Via FTP:**
```bash
# Upload updated files
upload electric-cycle.html
upload dashboard.html
chmod 644 electric-cycle.html dashboard.html
```

### **Step 3: Verify Config Directory Permissions**

**Via cPanel File Manager:**
1. Navigate to `public_html/config/`
2. Right-click on `config` folder
3. Select **Change Permissions**
4. Set to **755** (or **777** if 755 doesn't work)
5. Click **Change Permissions**

**Via FTP/SSH:**
```bash
chmod 755 config/
# Or if needed:
chmod 777 config/
```

**Important:** The `config/test-ride-requests.json` file will be **automatically created** when the first test ride request is submitted. No need to create it manually!

---

## ✅ Post-Upload Verification Checklist

After uploading, verify everything works:

### **1. Test API Endpoint**
Visit in browser:
```
https://yourdomain.com/api/test-ride-requests.php
```

**Expected Response:**
```json
{
  "success": true,
  "count": 0,
  "items": []
}
```

If you see this, the API is working! ✅

### **2. Test Form Submission**
1. Visit: `https://yourdomain.com/electric-cycle.html`
2. Scroll to "Book A Test Ride" form
3. Fill in all fields:
   - Full Name: Test User
   - Mobile: 9999999999
   - Email: test@example.com
   - City: Test City
   - Model: Evolution LP-001
4. Click **Submit Request**
5. Should see "Thank You!" popup ✅

### **3. Check Dashboard**
1. Visit: `https://yourdomain.com/dashboard.html`
2. Click **"Test Ride Requests"** in sidebar (bicycle icon 🚲)
3. Should see the test request you just submitted ✅
4. Table should show: Date, Name, Mobile, Email, City, Model

### **4. Verify Email Sending** (Optional)
1. Go to Dashboard → **SMTP Settings**
2. Verify SMTP is configured
3. Submit another test ride request
4. Check your email inbox (the email configured in SMTP settings)
5. Should receive email notification ✅

---

## 🔧 File Permissions Summary

| File/Folder | Permission | Why |
|------------|-----------|-----|
| `api/test-ride-requests.php` | **644** | Readable by web server |
| `electric-cycle.html` | **644** | Readable by web server |
| `dashboard.html` | **644** | Readable by web server |
| `config/` directory | **755** or **777** | Must be writable to create JSON files |
| `config/test-ride-requests.json` | **644** or **666** | Auto-created, must be writable |

---

## 🚨 Troubleshooting

### **Issue: "Failed to save request" error**
**Cause:** Config directory not writable  
**Solution:**
1. Check `config/` directory permissions (should be 755 or 777)
2. Via cPanel: Right-click `config` → Change Permissions → 755
3. Try submitting form again

### **Issue: API returns 404 error**
**Cause:** File not uploaded or wrong path  
**Solution:**
1. Verify `api/test-ride-requests.php` exists in `public_html/api/`
2. Check file permissions (should be 644)
3. Verify file name is exactly `test-ride-requests.php` (no typos)

### **Issue: Dashboard shows "Loading requests..." forever**
**Cause:** API endpoint not accessible or JavaScript error  
**Solution:**
1. Open browser console (F12)
2. Check for JavaScript errors
3. Check Network tab - see if `api/test-ride-requests.php` loads
4. Verify API file is uploaded correctly

### **Issue: Form submits but no popup appears**
**Cause:** JavaScript error or API error  
**Solution:**
1. Open browser console (F12)
2. Check for errors when submitting form
3. Check Network tab - see if POST to `api/test-ride-requests.php` succeeds
4. Verify `electric-cycle.html` file is updated

### **Issue: Email not sending**
**Cause:** SMTP not configured or mail() function disabled  
**Solution:**
1. Go to Dashboard → SMTP Settings
2. Verify SMTP credentials are saved
3. Test email sending from dashboard
4. Note: Email sending may not work on localhost, but will work on Hostinger if SMTP is configured

---

## 📝 Quick Upload Checklist

- [ ] Upload `api/test-ride-requests.php` (NEW)
- [ ] Upload `electric-cycle.html` (UPDATED)
- [ ] Upload `dashboard.html` (UPDATED)
- [ ] Set `config/` directory permissions to 755 or 777
- [ ] Test API endpoint: `https://yourdomain.com/api/test-ride-requests.php`
- [ ] Test form submission on electric-cycle page
- [ ] Verify requests appear in dashboard
- [ ] Test email notification (if SMTP configured)

---

## 🎯 What Happens After Upload

1. **First Test Ride Request:**
   - Form submits → API saves to `config/test-ride-requests.json`
   - Email notification sent (if SMTP configured)
   - Thank you popup appears

2. **Viewing Requests:**
   - Admin goes to Dashboard → Test Ride Requests
   - All requests displayed in table (newest first)
   - Can refresh to see latest requests

3. **Email Notifications:**
   - Each submission triggers email to SMTP recipient
   - Email includes: Name, Mobile, Email, City, Model, Time

---

## 📞 Need Help?

If something doesn't work:
1. Check browser console (F12) for errors
2. Verify all files are uploaded correctly
3. Check file permissions
4. Test API endpoint directly in browser
5. Check Hostinger error logs in cPanel

---

## ✅ Success Indicators

When everything is working correctly:

✅ API endpoint returns JSON: `{"success": true, "count": 0, "items": []}`  
✅ Form submission shows "Thank You!" popup  
✅ Dashboard "Test Ride Requests" section loads without errors  
✅ Requests appear in dashboard table after submission  
✅ Email notifications are sent (if SMTP configured)  

---

**Last Updated:** January 2026  
**Feature:** Test Ride Requests Backend & Dashboard Integration
