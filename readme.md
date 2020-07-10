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

Для использования xDebug, читайте [инструкцию](http://docs.flagstudio.ru/docs/1.0/xdebug_docker).


## CI/CD

### Доставка на тестовый

1. Для доставки на 35 (тестовый сервер) нужно перейти в проект в Gitlab, там зайти в Settings, затем CI/CD и раскрыть Variables. Добавить переменную с именем `PATH_STAGING_35` и значением, соответствующим пути на тестовом сервере (например, `/tools/project`).
2. В проекте откройте файл `.gitlab-ci.yml` и проверьте задания в джобе `deploy-develop`, можете отредактировать команды под свои нужды, например, если не хотите, чтобы ветка переключалась на `develop` (для веточных проектов), рекомендую такие команды:
```bash
- git stash &&
- git pull --ff--only
```

### Доставка на PROD

1. В переменных проекта на Gitlab пропишите `HOSTNAME_PROD`, туда вставьте ip-адрес или hostname PROD-сервера.
2. Если на проде SSH-пользователь не root, то добавьте переменную `USER_PROD` и пропишите туда имя SSH-юзера.
3. Закиньте на PROD-сервер ключ от Gitlab с помозью команды (выполнять на проде)

```bash
echo 'ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAINzEZnzSyxptGafdTLWgmehULOVjuz0azLH6TLUg9fbg gitlab-flagstudio.ru' >> ~/.ssh/authorized_keys
```

## PRODUCTION

### Сборка контейнера (на локале)

0. Выполните `cp .env.example .env`
1. Пропишите реквизиты доступа к Nova
0. Соберите образ приложения `dc -f docker-compose.build build app`
1. Залогиньтесь в нашем Docker registry с помощью ваших логина и пароля от Gitlab `docker login registry.gitlab.com`
2. Отправьте собранный образ в registry `dc push app`

### Настройка PROD-сервера

1. Закажите VPS с Ubuntu 16.04+ (можно 18.04)
2. Устновите скрипт BDSM и установите рекомендуемое ПО

```bash
eval "$(curl "https://raw.githubusercontent.com/michaelradionov/gg_installer/master/gg_installer.sh")" && gg_installer bdsm
bdsm --install-all
```

2. Установите Docker и Docker Compose с помощью `bdsm`, затем `9`, затем `8`.

3. В домашней директории создайте директорию

```bash
mkdir www
```

4. Скопируйте в эту директорию файл из текущего репозитория `docker-compose.prod.yml`, переименовав его в `docker-compose.yml`.
4. Скопируйте в эту директорию файл из текущего репозитория `.env.example`, переименовав его в `.env`.
5. Замените значения в файле `.env`

- `COMPOSE_PROJECT_NAME` - название проекта в Gitlab
- `APP_NAME` - Название проекта для людей. Можно по-русски. Используется как <title/> по умолчанию и еще в паре мест для админа.
- `APP_URL` - домен сайта с https://
- `DB_CONNECTION` - `pgsql` или `mysql`
- `DB_HOST` - `mysql` или `postgres`. Если запускаете без докера, то `localhost`
- `DB_DATABASE` - название проекта латинскими буквами
- `DB_USERNAME` - название проекта латинскими буквами
- `DB_PASSWORD` — сложный набор случайных символов. если вы установили BDSM, то выполните `genpass`

6. Перенесите с тестовой среды директорию `storage` или возьмите из этого репозитория. Команда для заливки с тестового (находясь в папке проекта на тестовом сервере).

```bash
scp -r storage root@<server_ip>:<site_dir>/
```

7. Выполните команду ниже. Если у вас проект с MySQL, то используйте `mysql`.

```bash
dc up -d caddy postgres
```


7. На этом шаге сайт уже должен кое-как запуститься
8. Залейте бэкап БД. BDSM поможет вам с импортом/экспортом БД, поиском с заменой домена и тд.


10. Когда сайт начнет открываться, отредактируйте `.env` еще раз
- `APP_ENV=production`
- `APP_DEBUG=false`
12. Настройте DNS. Обычно для нормальной работы сайта нужна запись типа A с именем "@" (и заодно вторая с именем "www") и значением равным IP вашего VPS-сервера.
13. Проверьте, правильно ли написан домен в файле `docker/ssl/Caddyfile_SSL`
14. Скопируйте `Caddyfile_SSL` в директорию проекта на PROD-сервере
11. Запустите Caddy, чтобы заработал https с помощью `dc up -d ssl`. Все должно заработать автоматически, если сервис Let's encrypt сможет получить доступ к  вашему сайту. То есть DNS уже должны быть настроены. Имейте ввиду, количество попыток получения сертификата ограничено.


##a Просто полезные команды Docker

### Просмотр

```bash
dc ps # выводит список контейнеров для данного проекта (надо выполнять в директории проекта, где docker-compose.yml)
dps # выводит список всех запущенных в системе контейнеров (полезно, чтобы узнать, какой проект запущен на сервере или чекнуть контейнеры, не переходя в директорию проекта)
dc logs -f --tail=1000 # выводит логи всех служб
dc logs -f --tail=1000 app # выводит логи службы php-fpm
```

### Чистка

Очень много места могут занимать неиспользуемые образы. Немного места могу занимать убитые контейнеры. Давайте удалим их все.

```bash
docker image prune
docker container prune
```
