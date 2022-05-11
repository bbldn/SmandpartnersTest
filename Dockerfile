FROM php:8.1-fpm

RUN \
    apt update; \
    apt install -y zip libzip-dev; \
    curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php; \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    docker-php-ext-install zip; \
    docker-php-ext-install pdo_mysql

RUN apt update; \
    apt install nodejs npm -y

COPY docker/php/run.sh /root

CMD "php-fpm"