
FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    git \
    zip \
    unzip 

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/

RUN a2enmod rewrite

EXPOSE 80