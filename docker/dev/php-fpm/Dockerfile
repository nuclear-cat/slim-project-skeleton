FROM php:8.2-fpm-alpine

RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache zip unzip curl

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    linux-headers

RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

ENV COMPOSER_ALLOW_SUPERUSER 1
