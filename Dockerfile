FROM php:7.3.6-fpm-alpine
WORKDIR /app

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev \
    && pecl install amqp-1.9.4 \
    && pecl install apcu-5.1.17 \
    && pecl install xdebug-2.7.0RC2 \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        pdo_mysql \
    && docker-php-ext-enable \
        amqp \
        apcu \
        opcache

COPY etc/infrastructure/php/ /usr/local/etc/php/

RUN mkdir -p /app/var/cache
RUN mkdir -p /app/var/logs
RUN chown -R www-data /app/var/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer global require "hirak/prestissimo" --prefer-dist --no-progress --no-suggest --classmap-authoritative \
	&& rm -rf /root/.composer/cache/*
