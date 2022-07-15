FROM php:8.1-apache

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN apt-get update && apt-get upgrade -y \
    git \
    curl \
    zip \
    unzip \
    vim

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer