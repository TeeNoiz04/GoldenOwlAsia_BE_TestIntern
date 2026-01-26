# FROM php:8.2-cli

# RUN apt-get update && apt-get install -y \
#     git curl zip unzip \
#     libpng-dev libjpeg-dev libfreetype6-dev \
#     libonig-dev libxml2-dev libzip-dev libicu-dev \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install \
#         pdo pdo_mysql mbstring exif bcmath gd zip intl

# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www
# COPY . .

# RUN composer install --no-dev --optimize-autoloader

# RUN mkdir -p storage/logs bootstrap/cache \
#  && chmod -R 775 storage bootstrap/cache

# EXPOSE 8080

# # CMD php artisan migrate --force && \
# #     php -S 0.0.0.0:8080 -t public
# COPY entrypoint.sh /entrypoint.sh
# RUN chmod +x /entrypoint.sh
# CMD ["/entrypoint.sh"]

# #CMD php artisan serve --host=0.0.0.0 --port=$PORT
# # CMD php artisan queue:work --tries=3 --timeout=90

