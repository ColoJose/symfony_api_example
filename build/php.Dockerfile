FROM php:8-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    git zlib1g-dev libxml2-dev libzip-dev wget && \
    docker-php-ext-install zip intl mysqli pdo pdo_mysql

# install composer
RUN wget https://getcomposer.org/download/2.0.2/composer.phar -O composer.phar -q && \
    chmod u+x composer.phar && mv composer.phar /bin/composer

COPY . .

RUN composer install --no-interaction

