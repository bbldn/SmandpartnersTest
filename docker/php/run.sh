#!/bin/bash

cd /var/www/html/front
npm install
make
make install

cd /var/www/html
composer install

dockerize -wait tcp://db:3306 -timeout 120s php bin/console doctrine:migrations:migrate --no-interaction

php-fpm