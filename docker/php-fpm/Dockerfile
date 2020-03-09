
ARG PHP_VERSION=${PHP_VERSION}
FROM php:${PHP_VERSION}-fpm-alpine

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
# Some huita for Supervisor
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

#COPY supervisord.conf /etc/supervisord.conf

#ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]


#
#--------------------------------------------------------------------------
# Check PHP version
#--------------------------------------------------------------------------
#

RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
