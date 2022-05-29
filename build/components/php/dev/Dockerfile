FROM php:8.0.18-fpm

# install required packages and php extenstions
RUN apt-get update \
    && apt-get install --quiet --assume-yes curl git unzip default-mysql-client libzip-dev libicu-dev locales \
        xvfb libxrender-dev libfontconfig1-dev \
    && docker-php-ext-install -j$(nproc) bcmath sockets pdo_mysql zip intl gd exif


# install php xdebug
RUN pecl install xdebug-3.1.4 apcu \
    && docker-php-ext-enable xdebug opcache apcu exif

# install composer globally
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# set php config
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY ./build/components/php/conf.d/*.ini "$PHP_INI_DIR/conf.d/"

# add training user with group www-data to be used by application
RUN useradd --create-home --groups www-data --shell /bin/bash training


# switch user to training
USER training

WORKDIR /srv/training
