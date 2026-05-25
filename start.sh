#!/bin/bash

# Exit on error
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=GestionCultivoSeeder --force
php artisan db:seed --class=VentaDistribucionSeeder --force
php artisan db:seed --class=GestionRecursosSeeder --force

# Cache config for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Laravel server (Render sets PORT env var)
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
