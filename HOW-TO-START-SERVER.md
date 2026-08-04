# 🚨 IMPORTANT: How to Start the Server Correctly

## The Problem

You're seeing this error:
```
SyntaxError: Unexpected token '<', "<?php hea"... is not valid JSON
```

This means your server is **NOT executing PHP files**. It's serving them as plain text.

## ✅ The Solution

You **MUST** use PHP's built-in development server, not a static file server.

### Step 1: Stop Your Current Server
Press `Ctrl+C` in the terminal where your server is running.

### Step 2: Start PHP Server

**Windows:**
```bash
php -S localhost:8000 router.php
```

Or simply double-click: **`start-server.bat`**

**Mac/Linux:**
```bash
php -S localhost:8000 router.php
```

Or run: `bash start-server.sh`

### Step 3: Verify It's Working

1. Open: http://localhost:8000/dashboard.html
2. Go to "SMTP Settings"
3. The form should load without errors
4. No more `SyntaxError` messages!

## ❌ What NOT to Use

These servers **WON'T WORK** because they don't execute PHP:

- ❌ `python -m http.server 8000`
- ❌ `http-server -p 8000` (Node.js)
- ❌ `npx serve`
- ❌ Any static file server

## 🔍 Check if PHP is Installed

Run this command:
```bash
php -v
```

You should see something like:
```
PHP 8.2.12 (cli) ...
```

If you get an error, install PHP first.

## 📝 Quick Reference

**Correct command:**
```bash
php -S localhost:8000 router.php
```

**Wrong commands:**
```bash
python -m http.server 8000  ❌
http-server -p 8000          ❌
npx serve                    ❌
```

## 🎯 After Starting PHP Server

- ✅ Dashboard will load SMTP config from backend
- ✅ Email sending will work
- ✅ All API endpoints will function
- ✅ No more JSON parsing errors

---

**Remember:** Always use `php -S localhost:8000 router.php` to start your server!

