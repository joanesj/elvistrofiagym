FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN sed -i 's|/var/www/html|/var/www/html/frontend|g' \
    /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

COPY . /var/www/html/

RUN chmod -R 755 /var/www/html/frontend/uploads

EXPOSE 80