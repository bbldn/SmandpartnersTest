FROM php:8.1-fpm

RUN \
    curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php; \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    docker-php-ext-install pdo_mysql

COPY docker/php/run.sh /root

#CMD bash /root/run.sh
CMD "php-fpm"