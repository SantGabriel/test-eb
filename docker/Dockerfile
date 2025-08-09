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
    && docker-php-ext-install pdo mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require laravel/installer

RUN a2enmod rewrite


ENV PATH="$PATH:/root/.composer/vendor/bin"

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf