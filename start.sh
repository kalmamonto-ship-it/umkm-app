#!/bin/bash
# Untuk hosting biasa, kita tidak menggunakan script ini
# File ini hanya untuk platform deployment seperti Render/Heroku

# Jika dijalankan, hanya tampilkan pesan
echo "Ini adalah aplikasi Laravel untuk hosting PHP biasa"
echo "Jalankan dengan web server seperti Apache dengan mod_rewrite enabled"

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install --legacy-peer-deps
npm run build

# Generate application key if not present
if [ -z "$APP_KEY" ]; then
    if [ ! -f .env ]; then
        cp .env.example .env
    fi
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Start the Laravel application
exec php artisan serve --host=0.0.0.0 --port=$PORT