FROM php:8.1-fpm

RUN \
    apt update; \
    apt install -y zip libzip-dev; \
    curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php; \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    docker-php-ext-install zip; \
    docker-php-ext-install pdo_mysql

RUN \
    cd /root; \
    apt update; \
    apt install curl -y; \
    curl -L https://nodejs.org/dist/v16.15.0/node-v16.15.0-linux-x64.tar.xz >> node-v16.15.0-linux-x64.tar.xz; \
    mkdir -p /usr/local/lib/nodejs; \
    tar -xJf node-v16.15.0-linux-x64.tar.xz -C /usr/local/lib/nodejs; \
    rm node-v16.15.0-linux-x64.tar.xz; \
    chmod +x /usr/local/lib/nodejs/node-v16.15.0-linux-x64/bin/npm; \
    chmod +x /usr/local/lib/nodejs/node-v16.15.0-linux-x64/bin/npx; \
    ln -s /usr/local/lib/nodejs/node-v16.15.0-linux-x64/bin/npm /bin/; \
    chmod +x /usr/local/lib/nodejs/node-v16.15.0-linux-x64/bin/node; \
    ln -s /usr/local/lib/nodejs/node-v16.15.0-linux-x64/bin/node /bin/

RUN \
    curl -L https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-linux-amd64-v0.6.1.tar.gz >> dockerize-linux-amd64-v0.6.1.tar.gz; \
    tar -xf dockerize-linux-amd64-v0.6.1.tar.gz -C /bin; \
    rm dockerize-linux-amd64-v0.6.1.tar.gz; \
    chmod +x /bin/dockerize

COPY docker/php/run.sh /root

CMD "php-fpm"