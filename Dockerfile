FROM php:7.1.31-apache-stretch

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && \
    apt-get install -y --no-install-recommends zlib1g-dev git zip unzip && \
    pecl install xdebug-2.5.5 && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install zip && \
    sed -e 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html/public!' \
        -ri /etc/apache2/sites-available/000-default.conf && \
    a2enmod rewrite && \
    curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    rm -rf /var/lib/apt/lists/*
