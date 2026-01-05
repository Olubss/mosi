# THIS MUST BE THE FIRST LINE
FROM php:8.2-fpm

# Install system dependencies (including GD for mPDF)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip libzip-dev unzip git nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Set the working directory
WORKDIR /var/www/html

# Copy composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy your project files
COPY . .

# NOW run permissions and install
RUN chmod -R 775 storage bootstrap/cache .env
RUN chown -R www-data:www-data storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Start the server
CMD php artisan serve --host=0.0.0.0 --port=10000