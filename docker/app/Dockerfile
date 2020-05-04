ARG PHP_VERSION
FROM registry.gitlab.com/flagstudio/laraflag:php-${PHP_VERSION}-base


###########################################################################
# Configs
###########################################################################


COPY ./docker/app/laraflag.ini /usr/local/etc/php/conf.d
COPY ./docker/app/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/app/supervisord.conf /etc/supervisord.conf
COPY ./docker/app/Caddyfile /etc/Caddyfile

###########################################################################
# Copy code
###########################################################################

USER www-data:www-data
COPY . /var/www/

###########################################################################
# Composer packages
###########################################################################

WORKDIR /var/www
USER root

RUN composer install --optimize-autoloader --no-dev --no-scripts
RUN composer dumpautoload

###########################################################################
# NPM
###########################################################################

RUN npm i
RUN npm run prod

###########################################################################
# Prepare Laravel for Prod
###########################################################################

RUN php artisan package:discover
RUN php artisan storage:link
RUN php artisan route:cache




ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

EXPOSE 8080
