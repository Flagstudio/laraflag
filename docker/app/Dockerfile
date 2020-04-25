FROM registry.gitlab.com/flagstudio/laraflag:base


###########################################################################
# Configs
###########################################################################


COPY ./docker2020/app/laraflag.ini /usr/local/etc/php/conf.d
COPY ./docker2020/app/www.conf /usr/local/etc/php-fpm.d/www.conf
#COPY ./php${LARADOCK_PHP_VERSION}.ini /usr/local/etc/php/conf.d/php.ini
COPY ./docker2020/app/supervisord.conf /etc/supervisord.conf
COPY ./docker2020/app/Caddyfile /etc/Caddyfile

###########################################################################
# Copy code
###########################################################################

USER www-data:www-data
COPY . /var/www/

###########################################################################
# Composer packages
###########################################################################

ARG NOVA_USERNAME
ARG NOVA_PASSWORD

WORKDIR /var/www
USER root

COPY composer.json /var/www/composer.json
COPY composer.lock /var/www/composer.lock

RUN composer config http-basic.nova.laravel.com ${NOVA_USERNAME} ${NOVA_PASSWORD}
RUN composer install --optimize-autoloader --no-dev --no-scripts
RUN composer dumpautoload

###########################################################################
# NPM
###########################################################################

RUN npm i
RUN npm run prod
RUN rm -rf node_modules

###########################################################################
# Prepare Laravel for Prod
###########################################################################

RUN php artisan package:discover
RUN php artisan storage:link
RUN php artisan route:cache




ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

EXPOSE 8080 2015
