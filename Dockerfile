FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

COPY . /var/www/html/

RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/frontend\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN chmod -R 755 /var/www/html/frontend/uploads

EXPOSE 80
