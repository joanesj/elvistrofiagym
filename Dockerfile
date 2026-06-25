FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY backend/ /var/www/html/backend/
COPY frontend/ /var/www/html/

EXPOSE 80