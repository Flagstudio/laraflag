#!/bin/sh

source /var/www/.env

/usr/bin/caddy -conf /etc/caddy/conf/Caddyfile_${APP_ENV} -agree

while inotifywait -e modify /etc/caddy; do
	pkill caddy
done

