FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar todo el proyecto
COPY . /var/www/html/

# Apuntar Apache al frontend como raíz
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/frontend\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Permisos uploads
RUN chmod -R 755 /var/www/html/frontend/uploads

EXPOSE 80