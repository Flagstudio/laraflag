FROM registry.gitlab.com/flagmaker/laraflag:base


###########################################################################
# Configs
###########################################################################


COPY ./docker/php-fpm/laraflag.ini /usr/local/etc/php/conf.d
COPY ./docker/php-fpm/xlaravel.pool.conf /usr/local/etc/php-fpm.d/
#COPY ./php${LARADOCK_PHP_VERSION}.ini /usr/local/etc/php/conf.d/php.ini
COPY ./docker/php-fpm/supervisord.conf /etc/supervisord.conf
COPY ./docker/php-fpm/Caddyfile /etc/Caddyfile

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
RUN composer global require hirak/prestissimo
RUN composer install --optimize-autoloader --no-dev --no-scripts
RUN composer dumpautoload

###########################################################################
# Prepare Laravel for Prod
###########################################################################

RUN php artisan package:discover
RUN php artisan storage:link
RUN php artisan route:cache




ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

EXPOSE 443 80 2015
