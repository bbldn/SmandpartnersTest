#!/bin/bash

sleep 30 # Ждём пока mysql точно запуститься
cd /var/www/html
composer install
php bin/console doctrine:migrations:migrate --no-interaction

php-fpm