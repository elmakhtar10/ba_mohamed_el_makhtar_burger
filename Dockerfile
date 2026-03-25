# Simple Laravel runtime image
FROM php:8.4-fpm

# System deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app
COPY . .

# Ensure Laravel cache dirs exist
RUN mkdir -p bootstrap/cache storage \
    && chown -R www-data:www-data bootstrap/cache storage \
    && chmod -R 775 bootstrap/cache storage

# Install PHP deps
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

EXPOSE 9000
CMD ["php-fpm"]
