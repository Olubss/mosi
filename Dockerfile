FROM php:8.2-fpm

# Install system dependencies and PHP extensions (including GD for mPDF)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip libzip-dev unzip git nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ... (after COPY . .)

# ONLY chmod folders that actually exist in your repo
RUN chmod -R 775 storage bootstrap/cache

# Change ownership so the web server can actually write to them
RUN chown -R www-data:www-data storage bootstrap/cache

# Run build steps
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Expose port and start
CMD php artisan serve --host=0.0.0.0 --port=10000