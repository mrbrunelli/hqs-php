
FROM php:7.2-apache

# PDO PostgreSQL e MySQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql mysqli 

# Instalar bibliotecas básicas PHP (Upload de imagem incluído)
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libjpeg-dev  \
    &&docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd


# Ativar mod_rewrite do .htaccess
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/