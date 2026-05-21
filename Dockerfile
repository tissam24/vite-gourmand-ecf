FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Active mod_rewrite
RUN a2enmod rewrite

# Définit le bon dossier racine
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Configure Apache pour pointer sur /var/www/html
RUN sed -i 's|/var/www/html|/var/www/html|g' /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
