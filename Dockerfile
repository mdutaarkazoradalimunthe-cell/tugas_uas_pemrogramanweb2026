# Stage 1: Build frontend assets dengan Node.js
FROM node:20-alpine AS node_builder

WORKDIR /var/www

COPY package*.json ./
RUN npm install

COPY resources/ ./resources/
COPY vite.config.js ./
COPY postcss.config.js ./
COPY tailwind.config.js ./
COPY public/ ./public/

RUN npm run build

# Stage 2: PHP + Nginx untuk aplikasi Laravel
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip \
    && echo "upload_max_filesize = 20M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

# Copy hasil build asset dari stage node_builder
COPY --from=node_builder /var/www/public/build ./public/build

COPY nginx.conf /etc/nginx/sites-available/default

COPY start.sh /start.sh
RUN chmod +x /start.sh

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 10000

CMD ["/start.sh"]
