
FROM php:7.2-apache

# PDO PostgreSQL e MySQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql mysqli

# Ativar mod_rewrite do .htaccess
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/