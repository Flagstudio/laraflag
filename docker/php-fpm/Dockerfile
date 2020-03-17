FROM php:7.2-fpm-alpine

#
#--------------------------------------------------------------------------
# Some ebala for PHP
#--------------------------------------------------------------------------
#


RUN apk --update add wget \
#  apt-utils \
  curl \
  git \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  zlib-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor \
  libzip-dev \
  icu-dev \
#  zlib1g-dev \
#  libicu-dev \
  g++ \
#  libmagickwand-dev \
  imagemagick

# For Imagick
RUN set -ex \
    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS imagemagick-dev libtool \
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && pecl install imagick-3.4.3 \
    && docker-php-ext-enable imagick \
    && apk add --no-cache --virtual .imagick-runtime-deps imagemagick \
    && apk del .phpize-deps

RUN docker-php-ext-install mysqli mbstring pdo pdo_mysql tokenizer xml pcntl bcmath opcache intl zip
RUN docker-php-ext-configure zip --with-libzip

RUN pecl channel-update pecl.php.net && pecl install memcached mcrypt-1.0.1 && docker-php-ext-enable memcached

RUN rm /var/cache/apk/* \
    && mkdir -p /var/www

#
#--------------------------------------------------------------------------
# Some govno for Caddy web server
#--------------------------------------------------------------------------
#
ARG VERSION="0.10.11"

RUN apk update && apk upgrade \
  && apk add --no-cache openssh-client git \
  && apk add --no-cache --virtual .build-dependencies tar curl

RUN curl --silent --show-error --fail --location \
      --header "Accept: application/tar+gzip, application/x-gzip, application/octet-stream" -o - \
      "https://github.com/mholt/caddy/releases/download/v${VERSION}/caddy_v${VERSION}_linux_amd64.tar.gz" \
    | tar --no-same-owner -C /usr/bin -xz \
 && chmod 0755 /usr/bin/caddy \
 && /usr/bin/caddy -version \
 && apk del .build-dependencies

#
#--------------------------------------------------------------------------
# Some huita for Supervisor
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

COPY ./docker/php-fpm/supervisord.conf /etc/supervisord.conf


#
#--------------------------------------------------------------------------
# Final huita
#--------------------------------------------------------------------------
#


COPY ./docker/php-fpm/laraflag.ini /usr/local/etc/php/conf.d
COPY ./docker/php-fpm/xlaravel.pool.conf /usr/local/etc/php-fpm.d/
#COPY ./php${LARADOCK_PHP_VERSION}.ini /usr/local/etc/php/conf.d/php.ini
COPY ./docker/php-fpm/Caddyfile /etc/Caddyfile

COPY . /var/www/


ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /var/www

EXPOSE 443 80 2015
