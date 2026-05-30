#!/bin/sh

# 1. Ensure SQLite database file exists if DB_CONNECTION is sqlite (or defaults to sqlite)
DB_CONN=${DB_CONNECTION:-sqlite}

if [ "$DB_CONN" = "sqlite" ]; then
    DB_PATH=${DB_DATABASE:-database/database.sqlite}
    echo "Using SQLite database at: $DB_PATH"
    
    # Extract directory name
    DB_DIR=$(dirname "$DB_PATH")
    if [ ! -d "$DB_DIR" ]; then
        mkdir -p "$DB_DIR"
    fi
    
    if [ ! -f "$DB_PATH" ]; then
        echo "Creating SQLite database file..."
        touch "$DB_PATH"
    fi
    
    # Ensure Apache (www-data) has write permissions on both the sqlite file and its parent folder
    chown -R www-data:www-data "$DB_DIR"
    chmod -R 775 "$DB_DIR"
    if [ -f "$DB_PATH" ]; then
        chmod 664 "$DB_PATH"
    fi
fi

# 2. Cache Laravel configuration, routes, and views for production
echo "Caching Laravel configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Run database migrations automatically
echo "Running database migrations..."
php artisan migrate --force

# 4. Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground
