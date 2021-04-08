FROM php:alpine

RUN docker-php-ext-install pdo_mysql
RUN apk add autoconf g++ make
RUN pecl install redis
RUN docker-php-ext-enable redis

COPY . /app
COPY .env.example /app/.env
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

RUN composer install

RUN php artisan key:generate

EXPOSE 8000

CMD php artisan serve --host 0.0.0.0
