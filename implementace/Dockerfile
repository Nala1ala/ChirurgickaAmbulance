FROM php:8.2-apache

LABEL authors="haaso"

RUN apt-get update && apt-get install -y zip unzip

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer