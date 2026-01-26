FROM php:8.2-cli

# PHP memory
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/logs bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache
 
CMD php artisan migrate --force && \
    if [ "$RUN_SEED" = "true" ]; then php artisan db:seed --force;

#CMD php artisan serve --host=0.0.0.0 --port=$PORT
# CMD php artisan queue:work --tries=3 --timeout=90
