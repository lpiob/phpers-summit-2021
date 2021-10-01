FROM php:8.0-apache

RUN pecl install redis-5.3.4 && docker-php-ext-enable redis && \
    apt update && apt install -y --no-install-recommends tcpdump procps
