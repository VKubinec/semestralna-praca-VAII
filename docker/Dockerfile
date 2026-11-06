# AI-assisted Docker setup for VAII assignment 6; PHP version pinned to 8.2.
FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql \
    && sed -ri 's!/var/www/html!/var/www/html/public!g' \
       /etc/apache2/sites-available/000-default.conf \
       /etc/apache2/apache2.conf \
       /etc/apache2/conf-available/docker-php.conf

WORKDIR /var/www/html
