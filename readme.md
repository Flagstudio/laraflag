# LaraFlag

Just a simple Laravel+Docker build that we use on our projects in FlagStudio.ru.

## Installation

1. Install Docker and Docker Compose. If you are using clean Ubuntu 16.04 like I do then you might find helpful this gist https://gist.github.com/michaelradionov/84879dc686e7f9e43bc38ecbbd879af4
2. Git clone this repo anywhere you want on your server
3. `cp .env.example .env`
4. Fill `.env` file with your project's variables
4. `docker-compose up -d caddy mysql`
5. `docker-compose exec workspace make install` or with BDSM `dew make install`



## Important notes

- Remove `"laravel/nova": "~1.0",` line from `composer.json` if you don't have Nova License.
- If you want to track errors from production server then add `LOG_SLACK_WEBHOOK_URL` in your `.env` with you Slack webhook URL as a value.
- Before using production environment make sure that you put your domain name in `docker/caddy/caddy/conf/Caddyfile_production` file
- We assume that when you are using production environment your domain is accessible from web. So that Caddy can get and install Let's Encrypt certificate for you. Otherwise you should put you domain in Caddyfile with http:// scheme like `http://yourdomain.com`.
- Don't forget to edit `COMPOSE_PROJECT_NAME` in your `.env` to see something nice in your terminal when running `docker-compose ps` for example.