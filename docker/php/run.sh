#!/bin/bash

cd /var/www/html/front
make
make install

sleep 10
cd /var/www/html
composer install
php bin/console doctrine:migrations:migrate --no-interaction

php-fpm