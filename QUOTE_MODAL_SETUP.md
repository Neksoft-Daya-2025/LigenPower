# Quote Request Modal & SMTP Integration Setup

## Overview
All "Request a Quote" buttons now open a modal popup, and all forms are integrated with SMTP email functionality.

## Files Created/Modified

### New Files:
1. **`assets/js/quote-modal.js`** - Modal component and quote request handler
2. **`assets/js/form-handler.js`** - Unified form handler for contact forms
3. **`api/get-smtp-config.php`** - API endpoint to retrieve SMTP config
4. **`api/save-smtp-config.php`** - API endpoint to save SMTP config

### Modified Files:
1. **`partials/footer.html`** - Added script includes for quote-modal.js and form-handler.js
2. **`api/send-email.php`** - Updated to load SMTP config from backend if not provided
3. **`dashboard.html`** - Updated to save SMTP config to backend
4. **`ligen-power-3500.html`** - Updated "Request A Quote" button
5. **`solar-street-light.html`** - Updated "Request A Quote" button

## Remaining Files to Update

The following product pages still need their "Request A Quote" buttons updated:
- ligen-power-5000.html
- ligen-power-2000.html
- ligen-power-1500.html
- ligen-power-1000.html
- ligen-power-850.html
- ligen-power-600s.html
- ligen-power-300.html
- ligen-inv5000-96vdc.html
- ligen-inv5000-48vdc.html
- ligen-inv2000-24vdc.html
- ligen-inv2000-pwm.html
- ligen-rrv1500-pwm.html
- ligen-inv1000-pwm.html
- ligen-inv850-pwm.html
- ligen-inv600-pwm.html
- ligen-inv300-pwm.html

## How to Update Remaining Buttons

Replace this pattern:
```html
<a href="contact.html" ...>Request A Quote</a>
```

With this:
```html
<a href="javascript:void(0);" onclick="openQuoteModal('PRODUCT_NAME', 'filename.html'); return false;" ... style="cursor: pointer;">Request A Quote</a>
```

Or for buttons linking to #contact-form:
```html
<a href="#contact-form" ...>Request A Quote</a>
```

Replace with:
```html
<a href="javascript:void(0);" onclick="openQuoteModal('PRODUCT_NAME', 'filename.html'); return false;" ... style="cursor: pointer;">Request A Quote</a>
```

## SMTP Configuration

1. Go to `dashboard.html`
2. Navigate to "SMTP Settings"
3. Fill in SMTP configuration:
   - SMTP Host (e.g., smtp.gmail.com)
   - SMTP Port (e.g., 587)
   - SMTP Username (your email)
   - SMTP Password (your email password or app password)
   - From Email
   - From Name
   - Encryption (TLS/SSL)
4. Click "Save SMTP Settings"
5. Optionally test with "Send Test Email"

## Forms Integrated with SMTP

1. **Quote Request Modal** - Opens when clicking "Request A Quote" buttons
2. **Contact Form** (`contact.html`) - Handled by form-handler.js
3. **Suggestions & Grievances Form** (`suggestions-grievances.html`) - Handled by form-handler.js
4. **Solar Street Light Form** (`solar-street-light.html`) - Handled by form-handler.js

## Email Recipient

By default, emails are sent to the email address configured in SMTP settings (fromEmail). To change the recipient email, update the `recipientEmail` field in the SMTP config in the dashboard.

## Testing

1. Configure SMTP in dashboard
2. Click any "Request A Quote" button - modal should open
3. Fill out the form and submit - email should be sent
4. Test contact form - should send email via SMTP
5. Test suggestions/grievances form - should send email via SMTP

