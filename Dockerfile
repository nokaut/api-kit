ARG PHP_VERSION=8.1
FROM php:${PHP_VERSION}-cli
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
            libzip-dev \
            unzip \
            zip; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*; \
    docker-php-ext-install zip

