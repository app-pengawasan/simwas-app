#!/bin/bash

# 1. Install Composer dependencies
composer install || { echo "Composer install failed"; exit 1; }

# 2. Install npm dependencies
npm install || { echo "npm install failed"; exit 1; }

# 3. Build assets, but continue even if it fails
npm run dev || echo "npm run dev failed, but continuing..."

# 4. Generate application key
php artisan key:generate || { echo "Key generation failed"; exit 1; }

# 5. Run database migrations with force option
php artisan migrate --force || { echo "Migrations failed"; exit 1; }

# 6. Seed the database
php artisan db:seed || { echo "Database seeding failed"; exit 1; }

# 7. Start the development server
php artisan serve || { echo "Development server start failed"; exit 1; }
