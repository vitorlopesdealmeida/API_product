#!/bin/sh

sleep 15

composer install
php artisan key:generate
php artisan module:migrate Product
php artisan module:seed Product

echo "*/15 * * * * php /var/www/html/artisan schedule:run >> /var/log/cron.log 2>&1" >> /etc/crontabs/root
crond

exec php-fpm
