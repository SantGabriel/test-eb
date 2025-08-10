FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    vim \
    && docker-php-ext-install pdo mbstring exif pcntl bcmath gd \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require laravel/installer

RUN a2enmod rewrite

RUN groupadd gabriel && useradd -m -g gabriel gabriel

RUN chown -R gabriel:gabriel /var/www/html

USER gabriel

ENV PATH="$PATH:/root/.composer/vendor/bin"

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini