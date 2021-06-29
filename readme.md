# Документация к сайту

Разработчик: [Студия Флаг](https://flagstudio.ru)

## Структура Docker Compose

### Конфиги Docker Compose

- **docker-compose.yml** — для локальной разработки
- **docker-compose.build.yml** — для сборки продуктового образа app (в нормальном режиме используется только в CI)
- **docker-compose.prod.yml** — конфиг для запуска на проде. Лежит на проде, переименованный в docker-compose.yml
- **docker-compose.build-base.yml** — конфиг для сборки базовых образов. Не должен использоваться разработчиками, так как нужен для создания образов **общих для всех проектов веб-студии**

### Службы

- **ssl** - caddy веб сервер (вместо nginx)
- **app** - php-fpm+caddy
- **mysql** - угадайте
- **postgres** - угадайте
- **elasticsearch** — угадайте
- **elastichq** — UI для эластика

### Конфиги

Общие

- **.env** — единственный конфиг не под Git'ом, поэтому м нем хранятся все настройки сайта и докера
- **docker/app/www.conf** — php-fpm
- **docker/app/laraflag.ini** — php
- **docker/app/crontab** — cron

Local

- **docker/app/supervisord_local.conf** — supervisor
- **docker/app/xdebug.ini** — xdebug

Prod

- **docker/app/opcache.ini** — opcache
- **docker/app/supervisord_build.conf** — supervisor
- **docker/ssl/Caddyfile_SSL** — Caddy

## LOCAL

Используйте docker-compose.yml, запускайте нужные службы, собирайте зависимости в `app`. Вот несоклько полезных команд для запуска на локале:


- `dc up -d postgres app` — запуск проекта
- `dc up --build -d app` — пересобрать образ и перезапустить контейнер
- `dc exec app composer install` — выполнение команд в контейнере
- `dc exec app bash` — подключиться к контейнеру
