FROM zuohuadong/caddy:alpine

#RUN caddyplug install cors

EXPOSE 443 80 2015
WORKDIR /var/www/public
CMD ["/usr/bin/caddy", "--conf", "/etc/Caddyfile", "-agree"]
