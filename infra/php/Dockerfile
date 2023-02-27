FROM php:8.2-fpm-alpine

# instalar extensiones
RUN docker-php-ext-install \
    pdo \
    pdo_mysql 

# instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# establece el directorio de trabajo en /home/app
WORKDIR /home/app
