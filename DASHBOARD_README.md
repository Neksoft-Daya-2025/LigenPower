# Dashboard Setup Guide

This guide will help you set up the admin dashboard with SMTP and Razorpay integration for your Ligen Power® website.

## Files Created

1. **dashboard.html** - Admin dashboard interface
2. **checkout.html** - Customer checkout page
3. **order-success.html** - Order confirmation page
4. **api/send-email.php** - SMTP email sending endpoint
5. **api/create-order.php** - Order creation endpoint
6. **api/create-razorpay-order.php** - Razorpay order creation endpoint
7. **api/verify-payment.php** - Payment verification endpoint

## Setup Instructions

### 1. Server Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx)
- cURL extension enabled (for Razorpay API calls)
- Optional: PHPMailer library for better email handling

### 2. Access the Dashboard

1. Open `dashboard.html` in your browser
2. The dashboard will load with default settings

### 3. Configure SMTP Settings

1. Navigate to **SMTP Settings** in the dashboard sidebar
2. Fill in the following details:
   - **SMTP Host**: Your email provider's SMTP server (e.g., `smtp.gmail.com`)
   - **SMTP Port**: Usually `587` for TLS or `465` for SSL
   - **SMTP Username**: Your email address
   - **SMTP Password**: Your email password or app-specific password
   - **From Email**: The email address to send from
   - **From Name**: Display name (e.g., "Ligen Power®")
   - **Encryption**: Choose TLS, SSL, or None

3. Click **Save SMTP Settings**
4. Test the configuration by entering a test email and clicking **Send Test Email**

**Note for Gmail Users:**
- Enable "Less secure app access" or use an App Password
- Generate an App Password: Google Account → Security → 2-Step Verification → App Passwords

### 4. Configure Razorpay Payment Gateway

1. Navigate to **Razorpay Settings** in the dashboard sidebar
2. Sign up or log in to [Razorpay Dashboard](https://razorpay.com)
3. Go to **Settings → API Keys**
4. Generate a new API key (or use existing one)
5. Copy the **Key ID** and **Key Secret**
6. Paste them in the dashboard form:
   - **Razorpay Key ID**: Your Razorpay Key ID (starts with `rzp_test_` or `rzp_live_`)
   - **Razorpay Key Secret**: Your Razorpay Key Secret
   - **Environment**: Choose Test Mode or Live Mode
7. Click **Save Razorpay Settings**

### 5. Add Products

1. Navigate to **Products** in the dashboard sidebar
2. Fill in the product details:
   - Product Name
   - Product Price (in ₹)
   - Product Image URL
   - Product Page URL
   - Product Description
   - Stock Quantity
3. Click **Add Product**

**Default Product:**
- The Electric Cycle product is already added by default with ID `electric-cycle-1`
- You can edit or delete it as needed

### 6. Enable Product Sales

The "Buy Now" button has been added to `electric-cycle.html`. When customers click it:
1. They are redirected to `checkout.html`
2. They fill in their details
3. They proceed to Razorpay payment
4. After successful payment, they see the order confirmation page

## How It Works

### Order Flow

1. **Customer clicks "Buy Now"** on product page
2. **Redirects to checkout.html** with product ID
3. **Customer fills form** with shipping details
4. **Razorpay order created** via `api/create-razorpay-order.php`
5. **Payment processed** through Razorpay checkout
6. **Payment verified** via `api/verify-payment.php`
7. **Order saved** via `api/create-order.php`
8. **Order confirmation** shown on `order-success.html`

### Data Storage

- **Dashboard settings** (SMTP, Razorpay): Stored in browser `localStorage`
- **Products**: Stored in browser `localStorage`
- **Orders**: Stored in `orders.json` file (server-side)

### Email Notifications

When an order is placed, you can send email notifications using the configured SMTP settings. The email functionality is available through `api/send-email.php`.

## Security Notes

⚠️ **Important Security Considerations:**

1. **API Keys**: Never commit Razorpay keys or SMTP passwords to version control
2. **HTTPS**: Always use HTTPS in production to protect sensitive data
3. **Server-side validation**: Add server-side validation for all inputs
4. **Rate limiting**: Implement rate limiting for API endpoints
5. **CORS**: Configure CORS properly for production use

## Testing

### Test Mode (Razorpay)

- Use test keys from Razorpay dashboard
- Test card: `4111 1111 1111 1111`
- Test CVV: Any 3 digits
- Test expiry: Any future date

### Production Mode

- Switch to Live Mode in Razorpay settings
- Use live API keys from Razorpay dashboard
- Ensure HTTPS is enabled

## Troubleshooting

### SMTP Not Working

- Check if SMTP port is correct (587 for TLS, 465 for SSL)
- Verify email credentials
- Check firewall settings
- For Gmail, ensure App Password is used

### Razorpay Payment Failing

- Verify API keys are correct
- Check if environment matches (test/live)
- Ensure cURL is enabled in PHP
- Check server logs for errors

### Orders Not Saving

- Check file permissions for `orders.json`
- Ensure `api/` directory is writable
- Check PHP error logs

## Support

For issues or questions:
- Razorpay Documentation: https://razorpay.com/docs/
- PHP Mail Documentation: https://www.php.net/manual/en/function.mail.php

## Next Steps

1. Set up SMTP and Razorpay configurations
2. Add your products through the dashboard
3. Test the checkout flow with test mode
4. Switch to live mode when ready for production
5. Monitor orders through the dashboard

