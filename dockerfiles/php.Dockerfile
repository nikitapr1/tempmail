FROM php:8.2-fpm

WORKDIR /var/www/laravel

RUN docker-php-ext-install pdo pdo_mysql


