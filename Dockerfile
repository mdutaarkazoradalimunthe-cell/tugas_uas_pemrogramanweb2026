FROM php:8.3-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy seluruh project
COPY . .

# Install dependency PHP (production, tanpa dev dependency)
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Copy konfigurasi nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Copy start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Set permission folder yang perlu writable
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 10000

CMD ["/start.sh"]
