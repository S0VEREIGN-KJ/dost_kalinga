@echo off
title Laravel Auto Launcher

echo [1/4] Starting XAMPP Control Panel...
start "" "C:\xampp\xampp-control.exe"

echo [2/4] Starting Apache and MySQL...
cd /d "C:\xampp"
call xampp_start.exe
timeout /t 1 >nul

echo [3/4] Running php artisan serve...
start "" cmd /c "cd /d C:\xampp\htdocs\laravel\dost_kalinga && php artisan serve"
timeout /t 5 >nul

echo [4/4] Opening browser to 127.0.0.1:8000...
start /wait "" "C:\Program Files\Google\Chrome\Application\chrome.exe" http://127.0.0.1:8000


