#!/bin/bash
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