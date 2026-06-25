FROM php:8.2-apache

COPY backend/ /var/www/html/
COPY frontend/ /var/www/html/frontend/

EXPOSE 80