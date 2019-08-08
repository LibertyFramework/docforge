FROM php:7.3.8-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends git \
 && pecl install xdebug-2.5.5 \
 && docker-php-ext-enable xdebug \
 && sed -e 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html/public!' -ri /etc/apache2/apache2.conf \
 && curl --silent --show-error https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && rm -rf /var/lib/apt/lists/*
