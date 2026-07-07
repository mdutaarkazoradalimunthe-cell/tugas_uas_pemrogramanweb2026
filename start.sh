#!/bin/bash

# Cache konfigurasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database (aman dijalankan berulang, hanya migrasi baru yang dijalankan)
php artisan migrate --force

# Seed template (idempotent — updateOrCreate, tidak bikin duplikat)
php artisan db:seed --class=TemplateSeeder --force

# Jalankan PHP-FPM di background
php-fpm -D

# Jalankan Nginx di foreground (supaya container tidak langsung exit)
nginx -g "daemon off;"
