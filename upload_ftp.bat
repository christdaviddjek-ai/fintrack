@echo off
REM Upload files to InfinityFree via FTP - Windows Batch Script
REM Requires Python to be installed

echo ========================================
echo   FTP UPLOAD - FINTRACK
echo ========================================
echo.

REM Check if Python is installed
python --version >nul 2>&1
if errorlevel 1 (
    echo.
    echo ERROR: Python not found!
    echo Please install Python from https://www.python.org/
    echo Make sure to check "Add Python to PATH" during installation.
    echo.
    pause
    exit /b 1
)

echo.
echo Python found. Running FTP upload...
echo.

REM Run the Python script
python ftp_upload_advanced.py

if errorlevel 1 (
    echo.
    echo ERROR: Upload failed!
    echo See UPLOAD_SOLUTIONS.md for alternatives (FileZilla, Control Panel)
    echo.
    pause
    exit /b 1
)

echo.
echo SUCCESS: Upload completed!
echo.
pause
