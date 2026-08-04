@echo off
echo ========================================
echo   PHP Development Server
echo ========================================
echo.
echo Starting server on: http://localhost:8000
echo.
echo IMPORTANT: Make sure PHP is installed and in your PATH
echo.
echo Press Ctrl+C to stop the server
echo.
echo ========================================
echo.
php -S localhost:8000 router.php
if errorlevel 1 (
    echo.
    echo ERROR: Could not start PHP server!
    echo.
    echo Please make sure:
    echo 1. PHP is installed
    echo 2. PHP is in your system PATH
    echo 3. Run: php -v to verify PHP is working
    echo.
    pause
)

