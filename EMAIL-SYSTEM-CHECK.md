# Email System Verification Checklist

## 📧 Email System Overview

The Ligen Power® website uses SMTP for sending emails through various forms:
1. **Quote Request Modal** - Product quote requests
2. **Contact Form** - General inquiries
3. **Suggestions & Grievances Form** - Feedback submissions
4. **Solar Street Light Form** - Quote requests for solar products

## ✅ Components Check

### 1. API Endpoints
- ✅ `api/get-smtp-config.php` - Retrieves SMTP configuration
- ✅ `api/save-smtp-config.php` - Saves SMTP configuration from dashboard
- ✅ `api/send-email.php` - Sends emails via SMTP (with PHPMailer fallback to mail())

### 2. JavaScript Files
- ✅ `assets/js/quote-modal.js` - Handles quote request modal and email sending
- ✅ `assets/js/form-handler.js` - Handles contact forms and other form submissions

### 3. Configuration Storage
- ✅ SMTP config stored in: `config/smtp-config.json` (created automatically)
- ✅ SMTP config also cached in browser `localStorage` for faster access

## 🔧 How to Test Email Functionality

### Step 1: Configure SMTP in Dashboard
1. Open `dashboard.html` in your browser
2. Navigate to "SMTP Configuration" section
3. Fill in your SMTP details:
   - **SMTP Host** (e.g., smtp.gmail.com)
   - **SMTP Port** (e.g., 587 for TLS, 465 for SSL)
   - **SMTP Username** (your email)
   - **SMTP Password** (your email password or app password)
   - **From Email** (sender email address)
   - **From Name** (sender name)
   - **Encryption** (TLS or SSL)
4. Click "Save SMTP Settings"
5. Click "Test SMTP" to verify configuration

### Step 2: Use Test Page
1. Open `test-email.html` in your browser
2. Click "Check SMTP Config" to verify configuration is loaded
3. Enter a test email address
4. Click "Send Test Email" to test email sending
5. Check your inbox for the test email

### Step 3: Test Real Forms
1. **Quote Request**: Click "Request A Quote" on any product page
2. **Contact Form**: Submit the contact form on `contact.html`
3. **Suggestions Form**: Submit feedback on `suggestions-grievances.html`

## 🐛 Troubleshooting

### Issue: "SMTP configuration not found"
**Solution**: 
- Make sure SMTP is configured in the dashboard
- Check that `config/smtp-config.json` exists
- Verify the config directory has write permissions

### Issue: "Failed to send email"
**Possible Causes**:
1. **SMTP credentials incorrect** - Verify username/password
2. **Port/Encryption mismatch** - Check SMTP settings match your provider
3. **Firewall blocking** - Ensure port 587/465 is not blocked
4. **Gmail App Password** - If using Gmail, use App Password instead of regular password
5. **PHPMailer not installed** - System will fallback to PHP mail() function

### Issue: Emails going to spam
**Solution**:
- Use a proper "From Email" address matching your domain
- Set up SPF/DKIM records for your domain
- Use a professional email service (not free Gmail/Yahoo)

## 📋 Email Flow

```
User submits form
    ↓
JavaScript (quote-modal.js / form-handler.js)
    ↓
Loads SMTP config (localStorage → API)
    ↓
Sends POST request to api/send-email.php
    ↓
PHP checks for PHPMailer (preferred) or uses mail()
    ↓
Email sent via SMTP
    ↓
Success/Error response to user
```

## 🔐 Security Notes

- SMTP credentials are stored in `config/smtp-config.json`
- **IMPORTANT**: Add `config/` to `.gitignore` to prevent committing credentials
- Consider using environment variables in production
- Use App Passwords for Gmail instead of regular passwords

## ✅ Quick Verification Checklist

- [ ] SMTP configured in dashboard
- [ ] Test email sent successfully
- [ ] Quote request modal works
- [ ] Contact form works
- [ ] Suggestions form works
- [ ] Error messages display correctly
- [ ] Success messages display correctly
- [ ] Emails received in inbox (not spam)

## 📞 Support

If emails are not working:
1. Check browser console for JavaScript errors
2. Check server error logs for PHP errors
3. Verify SMTP settings with your email provider
4. Test SMTP connection using the dashboard test function
5. Ensure PHP mail() function works if PHPMailer is not available

