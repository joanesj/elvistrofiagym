FROM php:8.2-apache

# Instalar extensión PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copiar todo el proyecto al directorio web de Apache
COPY . /var/www/html/

# Apuntar Apache al frontend (donde están los .php principales)
RUN sed -i 's|/var/www/html|/var/www/html/frontend|g' /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Permisos para la carpeta de uploads
RUN chmod -R 755 /var/www/html/frontend/uploads

EXPOSE 80