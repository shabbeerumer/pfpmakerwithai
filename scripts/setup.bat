@echo off
SETLOCAL EnableDelayedExpansion

echo Checking Python installation...
python --version >nul 2>&1
if errorlevel 1 (
    echo Python is not installed. Please install Python 3.7 or higher.
    exit /b 1
)

echo Checking pip installation...
pip --version >nul 2>&1
if errorlevel 1 (
    echo pip is not installed. Please install pip.
    exit /b 1
)

echo Creating virtual environment...
if exist venv (
    echo Removing existing virtual environment...
    rmdir /s /q venv
)
python -m venv venv

echo Activating virtual environment...
call venv\Scripts\activate.bat
if errorlevel 1 (
    echo Failed to activate virtual environment.
    exit /b 1
)

echo Installing requirements...
pip install --upgrade pip
pip install -r requirements.txt
if errorlevel 1 (
    echo Failed to install requirements.
    exit /b 1
)

echo Testing rembg installation...
python -c "from rembg import remove" 2>nul
if errorlevel 1 (
    echo WARNING: rembg installation test failed.
    echo Please try running: pip install rembg==2.0.50
    exit /b 1
)

echo Setup completed successfully!
echo Virtual environment is ready at: %CD%\venv 