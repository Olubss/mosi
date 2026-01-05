# 1. Set the working directory
WORKDIR /var/www/html

# 2. NOW copy your project files from your Mac to the Docker image
COPY . .

# 3. NOW you can run chmod, because the files actually exist in /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# 4. Change ownership
RUN chown -R www-data:www-data storage bootstrap/cache

# 5. Install dependencies
RUN composer install --no-dev --optimize-autoloader