FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
      bash git unzip icu-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install -j$(nproc) \
      pdo_mysql intl mbstring zip opcache \
    && rm -rf /var/cache/apk/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

CMD ["php-fpm"]
