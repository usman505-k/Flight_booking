#!/bin/bash
# railway/init-app.sh
set -e

composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan storage:link || true

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache || true