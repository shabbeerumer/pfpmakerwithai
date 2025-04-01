# PFP Maker with AI

## Overview

PFP Maker with AI is a web application that allows users to create professional profile pictures using AI-powered image processing. The application provides various tools for enhancing, editing, and customizing profile pictures, including background removal, applying filters, and adding custom backgrounds.

![PFPMaker Screenshot](public/images/logo.svg)

## Features

- **Background Removal**: Automatically remove backgrounds from profile pictures using AI
- **Image Enhancement**: Improve image quality and appearance
- **Custom Backgrounds**: Apply various background options or upload your own
- **Filters and Effects**: Apply filters to enhance your profile picture
- **Cropping and Resizing**: Adjust your profile picture to fit different social media platforms
- **Social Sharing**: Share your created profile pictures directly to social media platforms
- **Save to Collection**: Save your creations to your personal collection

## Technology Stack

- **Backend**: PHP with Laravel 11 framework
- **Frontend**: HTML, CSS, JavaScript with Bootstrap 5 and Tailwind CSS
- **Image Processing**: 
  - PHP Intervention/Image library
  - Python with rembg for AI-powered background removal
- **Database**: MySQL

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- Python 3.7 or higher
- pip (Python package installer)
- MySQL or compatible database

### Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/shabbeerumer/pfpmakerwithai.git
   cd pfpmakerwithai
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create and configure your environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database connection in the `.env` file.

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Build frontend assets:
   ```bash
   npm run build
   ```

8. Set up background removal feature:

   #### Windows
   ```bash
   cd scripts
   setup.bat
   ```

   #### Linux/Mac
   ```bash
   cd scripts
   chmod +x setup.sh
   ./setup.sh
   ```

9. Create storage symbolic link:
   ```bash
   php artisan storage:link
   ```

10. Start the development server:
    ```bash
    php artisan serve
    ```

## Background Removal Setup

This project uses Rembg for background removal. The setup scripts in the `scripts` directory will:
1. Create a Python virtual environment
2. Install required dependencies
3. Set up Rembg for background removal

### Troubleshooting
If you encounter any issues with background removal:
1. Make sure Python 3.7 or higher is installed and accessible from the command line
2. Ensure pip is installed and up to date
3. Check the logs for specific error messages
4. Make sure you have sufficient disk space for the Python packages

## Usage

1. Navigate to the home page
2. Upload your image
3. Use the editor tools to enhance your profile picture
4. Remove the background if desired
5. Apply filters or effects
6. Save or share your creation

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
