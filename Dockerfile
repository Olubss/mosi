FROM php:8.2-fpm

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libgmp-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# 2. Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip mysqli gmp bcmath

# 3. Set working directory
WORKDIR /var/www/html

# 4. Copy Composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copy your project files
COPY . .

# 6. Set permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache .env \
    && chown -R www-data:www-data storage bootstrap/cache

# 7. Install dependencies and build assets
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 8. Start the server
CMD php artisan serve --host=0.0.0.0 --port=10000