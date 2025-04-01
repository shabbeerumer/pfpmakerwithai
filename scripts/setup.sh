#!/bin/bash

# Check if Python is installed
if ! command -v python &> /dev/null; then
    echo "Python is not installed. Please install Python 3.7 or higher."
    exit 1
fi

# Check if pip is installed
if ! command -v pip &> /dev/null; then
    echo "pip is not installed. Please install pip."
    exit 1
fi

# Create virtual environment
python -m venv venv

# Activate virtual environment
source venv/bin/activate || source venv/Scripts/activate

# Install requirements
pip install -r requirements.txt

echo "Setup completed successfully!" 