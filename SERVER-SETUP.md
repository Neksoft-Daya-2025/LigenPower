# Server Setup Guide

## ⚠️ Important: PHP Server Required

Your website uses PHP for backend functionality (SMTP, email sending, etc.). You **must** use PHP's built-in server, not a simple static file server.

## 🚀 How to Start the Server

### Windows:
1. Open Command Prompt or PowerShell in this directory
2. Run: `php -S localhost:8000`
   - OR double-click `start-server.bat`

### Mac/Linux:
1. Open Terminal in this directory
2. Run: `php -S localhost:8000`
   - OR run: `bash start-server.sh`

## ✅ What This Does

- Executes PHP files (API endpoints)
- Handles POST/GET requests properly
- Enables SMTP email functionality
- Allows dashboard to save/load configurations

## ❌ Don't Use These (They Won't Work):

- Python's `python -m http.server 8000` ❌
- Node's `http-server -p 8000` ❌
- Any static file server ❌

These servers don't execute PHP, so your API endpoints won't work!

## 🔍 Verify It's Working

1. Start the PHP server: `php -S localhost:8000`
2. Open: http://localhost:8000/dashboard.html
3. Go to SMTP Settings
4. The form should load your SMTP configuration without errors

## 📝 Current Server Status

If you see errors like:
- `SyntaxError: Unexpected token '<', "<?php hea"...`
- `501 (Unsupported method ('POST'))`

This means you're using a static file server. Switch to PHP's built-in server using the commands above.

