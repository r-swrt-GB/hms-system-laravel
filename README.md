# HMS-System API Documentation

![HMS-System Logo](https://health-sciences.nwu.ac.za/sites/health-sciences.nwu.ac.za/files/styles/max_1300x1300/public/files/image/1.png?itok=LnMA_Ypy)

## Table of Contents
1. [Introduction](#introduction)
2. [Prerequisites](#prerequisites)
3. [Installation](#installation)
4. [Running the Application](#running-the-application)
5. [Database Setup](#database-setup)
6. [API Usage](#api-usage)
7. [Windows Users](#windows-users)
8. [Troubleshooting](#troubleshooting)

## Introduction

The HMS-System API facilitates seamless interaction between lecturers and students in an educational environment. This API enables lecturers to create and manage assignments on a web platform, which include a video and a detailed description. Students can access these assignments via a mobile application, allowing them to submit their own video responses.

Key functionalities include:
- **Assignment Management**: Lecturers can create, update, and delete assignments.
- **Submission Handling**: Students can submit their video responses directly through the mobile app.
- **Feedback Mechanism**: Lecturers can review submissions, provide marks, and leave comments.

This README will guide you through the setup and usage of the HMS-System API.

## Prerequisites

Before you begin, ensure you have the following installed on your system:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)
- [Composer](https://getcomposer.org/download/) (for local development)
- [PHP](https://www.php.net/downloads.php) (version 8.2 or higher)
- [Node.js](https://nodejs.org/en/download/) (version 14.x or higher)
- [npm](https://www.npmjs.com/get-npm) (usually comes with Node.js)

To check your installed versions:
- For PHP: `php -v`
- For Node.js: `node -v`
- For npm: `npm -v`

Ensure that your PHP installation has the required extensions for Laravel, such as php-mbstring, php-xml, php-curl, etc.

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/r-swrt-GB/hms-system-laravel.git
   cd hms-system-laravel
   ```

2. Copy the environment file:
   ```
   cp .env.example .env
   ```

3. Install Composer dependencies:
   ```
   composer install
   ```

4. Install npm dependencies:
   ```
   npm install
   ```

5. Build the frontend assets:
   ```
   npm run build
   ```

## Running the Application

1. Start the Docker containers using Laravel Sail:
   ```
   ./vendor/bin/sail up -d
   ```

2. Generate an application key:
   ```
   ./vendor/bin/sail artisan key:generate
   ```

3. Run database migrations and seeders:
   ```
   ./vendor/bin/sail artisan migrate --seed
   ```

The application should now be running at `http://localhost:8015`.

## Database Setup

The database is automatically set up when you run the migrations and seeders. However, if you need to reset the database, you can use:

```
./vendor/bin/sail artisan migrate:fresh --seed
```

## API Usage

1. Register a new account using the registration endpoint.

2. Use the returned bearer token in Postman to authenticate your requests.

3. Access the Postman collection for this API using the following link:
   [HMS-System API Postman Collection](https://hms-system-team.postman.co/workspace/HMS-System-API-V1~a009c4f3-28d1-4824-a5d0-21653cd45f0b/collection/38045529-%20a28a93f5-1b5d-41e0-9768-a193cec78d3f?action=share&creator=38045529)

4. In Postman, set the `{{base_url_docker}}` variable to `http://localhost:8015` for making requests to the Docker setup.

## Windows Users

If you encounter issues running nginx on Windows:

1. Stop the Docker containers:
   ```
   ./vendor/bin/sail down
   ```

2. Start the Laravel development server:
   ```
   php artisan serve
   ```

3. In Postman, use the `{{base_url_local}}` variable instead of `{{base_url_docker}}`. Set `{{base_url_local}}` to `http://127.0.0.1:8000`.

## Troubleshooting

If you encounter any issues:

1. Ensure all Docker containers are running:
   ```
   docker ps
   ```

2. Check Docker logs:
   ```
   ./vendor/bin/sail logs
   ```

3. If you make changes to the Dockerfile or docker-compose.yml, rebuild the containers:
   ```
   ./vendor/bin/sail build --no-cache
   ```

For further assistance, please open an issue in the GitHub repository.
