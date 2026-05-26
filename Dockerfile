# Dockerfile for Laravel 13 with PHP 8.4
# Multi-stage build: build frontend assets with Node, install PHP dependencies, then runtime image.

FROM node:20-slim AS node-builder
WORKDIR /var/www/html
COPY package*.json ./
RUN npm install --silent
COPY . .
RUN npm run build

FROM php:8.4-fpm-bullseye AS php-builder
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libicu-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY composer*.json ./
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction
COPY . .
COPY --from=node-builder /var/www/html/public/build ./public/build
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate --force

FROM php:8.4-fpm-bullseye AS runtime
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libicu-dev \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

WORKDIR /var/www/html
COPY --from=php-builder /var/www/html /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
