#!/bin/sh

# Cache configurations at runtime so Laravel reads environment variables injected by Render
echo "Caching Laravel configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically
echo "Running database migrations..."
php artisan migrate --force

# Start Apache in the foreground
echo "Starting Apache..."
exec apache2-foreground
