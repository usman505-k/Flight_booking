echo '#!/bin/bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan key:generate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache'