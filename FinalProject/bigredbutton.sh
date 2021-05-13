#! /bin/sh
php artisan cache:clear
php artisan route:cache
php artisan config:cache
php artisan view:clear
php artisan config:cache
php artisan config:clear
