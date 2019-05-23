FROM zuohuadong/caddy:alpine

LABEL maintainer="Huadong Zuo <admin@zuohuadong.cn>"

ARG plugins="cors"

## ARG plugins="cors cgi cloudflare azure linode"

RUN caddyplug install ${plugins}

RUN apk add --no-cache inotify-tools
ADD caddy/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80 443 2015

WORKDIR /var/www/public

CMD ["sh","-c","/start.sh"]
