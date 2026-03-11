#!/bin/bash
set -e

# Copy .env
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install packages
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate keys
php artisan key:generate --no-interaction

# Wait MySQL startup
echo "Waiting for MySQL..."
until php artisan db:show > /dev/null 2>&1; do
  echo "MySQL is still booting up..."
  sleep 2
done
echo "MySQL is up - executing migrations"

# Run migrations
php artisan migrate --force

# Restore laravel dir structure
mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions

# Set correct user for public dirs
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan optimize:clear

# Execute the main container process (php-fpm)
exec docker-php-entrypoint "$@"
