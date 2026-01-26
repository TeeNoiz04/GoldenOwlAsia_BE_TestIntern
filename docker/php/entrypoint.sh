# #!/usr/bin/env bash
# set -e

# # Ensure proper permissions
# mkdir -p /var/www/storage/logs /var/www/bootstrap/cache
# chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
# chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# # Optimize caches (ignore failures if env not ready)
# php /var/www/artisan optimize:clear || true
# php /var/www/artisan config:cache || true
# php /var/www/artisan route:cache || true
# php /var/www/artisan view:cache || true

# # Optionally run database migrations/seeds via env flags
# if [ "${RUN_MIGRATIONS}" = "true" ]; then
#   php /var/www/artisan migrate --force || true
# fi
# if [ "${RUN_SEEDS}" = "true" ]; then
#   php /var/www/artisan db:seed --force || true
# fi

# # Warn if APP_KEY missing (prefer setting via env on Railway)
# if [ -z "${APP_KEY}" ]; then
#   echo "[WARN] APP_KEY is not set. Set it in Railway variables."
# fi

# # Start Nginx in background
# nginx -g 'daemon off;' &

# # Start PHP built-in server on the specified PORT
# php -S 0.0.0.0:${PORT_ENV} -t /var/www/public /var/www/public/index.php

#!/bin/sh
set -e

echo "⏳ Waiting for database..."

until php artisan migrate:status > /dev/null 2>&1
do
  sleep 2
done

echo "✅ Database ready"

php artisan migrate --force

if [ "$RUN_SEED" = "true" ]; then
  echo "🌱 Seeding database..."
  php artisan db:seed --force
else
  echo "⚠️ RUN_SEED not enabled, skip seeding"
fi

echo "🚀 Starting server"
php artisan serve --host=0.0.0.0 --port=8080
