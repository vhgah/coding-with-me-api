# ===== Stage 1: Composer Dependencies =====
FROM composer:2.7.2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction

# ===== Stage 2: PHP Application =====
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    zip \
    bcmath \
    opcache

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY . .

# Copy vendor from composer stage
COPY --from=composer /app/vendor ./vendor

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Clear cache and optimize (can be overridden in dev)
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
