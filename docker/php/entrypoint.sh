#!/usr/bin/env bash
set -e

# Default PORT to 8080 if not provided
PORT_ENV=${PORT:-8080}

# Update Nginx listen port dynamically
if grep -q "listen " /etc/nginx/conf.d/default.conf; then
  sed -i "s/listen [0-9]\+;/listen ${PORT_ENV};/" /etc/nginx/conf.d/default.conf
else
  echo "server { listen ${PORT_ENV}; root /var/www/public; index index.php index.html; }" > /etc/nginx/conf.d/default.conf
fi

# Ensure proper permissions
mkdir -p /var/www/storage/logs /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Optimize caches (ignore failures if env not ready)
php /var/www/artisan optimize:clear || true
php /var/www/artisan config:cache || true
php /var/www/artisan route:cache || true
php /var/www/artisan view:cache || true

# Optionally run database migrations/seeds via env flags
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php /var/www/artisan migrate --force || true
fi
if [ "${RUN_SEEDS}" = "true" ]; then
  php /var/www/artisan db:seed --force || true
fi

# Warn if APP_KEY missing (prefer setting via env on Railway)
if [ -z "${APP_KEY}" ]; then
  echo "[WARN] APP_KEY is not set. Set it in Railway variables."
fi

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g 'daemon off;'
