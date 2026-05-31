FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql bcmath gd zip opcache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Change Apache Document Root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Run composer install for production (no dev dependencies, optimized autoloader)
RUN composer install --no-dev --optimize-autoloader

# Adjust permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose container port
EXPOSE 80

# Start production optimizations, create storage symlink, run migrations, seed database, and start Apache web server
CMD sh -c "if [ \"\${DB_CONNECTION:-sqlite}\" = \"sqlite\" ]; then if [ ! -f database/database.sqlite ]; then mkdir -p database && touch database/database.sqlite; fi; fi && rm -rf public/storage && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan db:seed --force && chown -R www-data:www-data storage bootstrap/cache database public/storage && chmod -R 775 storage bootstrap/cache database public/storage && apache2-foreground"
