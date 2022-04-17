FROM php:8.0-fpm-alpine3.14

RUN apk update && apk add curl git vim

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions xdebug json pdo pdo_mysql @composer

WORKDIR /var/www/html/laravelapp