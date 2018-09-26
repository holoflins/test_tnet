FROM php:7-fpm-alpine3.7

COPY ./www/ /var/www/html
WORKDIR /var/www/html

RUN docker-php-ext-install \
      pdo \
      pdo_mysql \
    && apk add --update \
      --repository http://dl-3.alpinelinux.org/alpine/edge/community/ \
      --repository http://dl-3.alpinelinux.org/alpine/edge/main/ \
      git \
      openssh-client \
      composer \
      fontconfig \
      libxrender \
      libxext \
    && rm -rf /var/cache/apk/* $HOME/.cache

RUN composer install --no-dev --no-scripts \
    && chown -R 82:82 /var/www/html
