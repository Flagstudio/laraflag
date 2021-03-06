# Документация к сайту

Разработчик: [Студия Флаг](https://flagstudio.ru)

Дата публикации сайта: март 2020

Адрес сайта (прод): <URL сайта>

Данная инструкция покрывает ТОЛЬКО запуск сайта в docker-compose (требования к серверу в конце). Подразумевается, что на сервере установлен `make` и в корне сайта есть Makefile.

## Настройка PROD-сервера (запуск на проде)

1. Закажите VPS с Ubuntu 16.04+ (можно 18.04)
2. Устновите скрипт BDSM и установите рекомендуемое ПО

```bash
eval "$(curl "https://raw.githubusercontent.com/michaelradionov/gg_installer/master/gg_installer.sh")" && gg_installer bdsm
bdsm --install-all
```

2. Установите Docker и Docker Compose с помощью `bdsm`, затем `9`, затем `8`.

3. В домашней директории создайте директорию с именем (доменом) сайта

```bash
mkdir <site.ru>
```

4. Перейдите в эту директорию и склонируйте в нее код сайта из Git репозитория (спросите адрес репозитория у вашего менеджера. контакты менеджера обычно указаны на главной странице в админке сайта)

```bash
cd <site.ru>
git clone <git_repo_url> .
```

5. Создайте файл `.env` и измените в нем значения на нужные (смотри ниже)

```bash
cp .env.example .env
nano .env
```

- `COMPOSE_PROJECT_NAME` - название проекта латинскими буквами (системное имя для Docker)
- `APP_NAME` - Название проекта для людей. Можно по-русски. Используется как <title/> по умолчанию и еще в паре мест для админа.
- `APP_URL` - домен сайта с https://
- `APP_URL_PROD` - домен сайта без https://
- `DB_CONNECTION` - `pgsql` или `mysql`
- `DB_HOST` - `mysql` или `postgres`. Если запускаете без докера, то `localhost`
- `DB_DATABASE` - название проекта латинскими буквами
- `DB_USERNAME` - название проекта латинскими буквами
- `DB_PASSWORD` — сложный набор случайных символов. если вы установили BDSM, то выполните `genpass`

7. Выполните команду ниже. Возможно у вас проект с mysql, а не postgres. Уточните у менеджера.

```bash
dc up -d caddy postgres
```

6. Выполните `make start-prod` и ждите. В какой-то момент установщик попросит доступы к Nova. Запросите их у вашего менеджера или удалите строку `"laravel/nova": "~1.0",` из `composer.json`

```bash
make start-prod
```
или, если у вас устаревший Makefile или не установлен make
```bash
docker-compose up -d caddy postgres php-worker
docker-compose exec workspace composer install --no-dev -q
docker-compose exec workspace php artisan key:generate
docker-compose exec workspace php artisan storage:link
docker-compose exec workspace php artisan config:cache
docker-compose exec workspace php artisan route:cache
docker-compose exec workspace npm i
docker-compose exec workspace npm run prod
chmod -R 777 bootstrap/ storage/
```

7. На этом шаге сайт уже должен кое-как запуститься
8. Залейте бэкап БД. BDSM поможет вам с импортом/экспортом БД, поиском с заменой домена и тд.
9. Залейте содержимое загруженные медиаматериалы с помощью scp. Например, из корневой директории сайта на локале или тестовой площадке.

```bash
scp -r storage root@<server_ip>:<site_dir>/
```
10. Отредактируйте `.env` еще раз
- `APP_ENV=production`
- `APP_DEBUG=false`
12. Настройте DNS. Обычно для нормальной работы сайта нужна запись типа A с именем "@" (и заодно вторая с именем "www") и значением равным IP вашего VPS-сервера.
11. Перезапустите Caddy, чтобы заработал https. Все должно заработать автоматически, если сервис Let's encrypt сможет получить доступ к  вашему сайту. То есть DNS уже должны быть настроены. Имейте ввиду, количество попыток получения сертификата ограничено.

```bash
dc caddy restart
```
или, если у вас устаревший Makefile или не установлен make
```bash
	git stash
	git fetch origin master
	git checkout master
	git reset --hard origin/master
	docker-compose exec workspace composer install --no-dev -q
	docker-compose exec workspace php artisan migrate --force --quiet
	docker-compose exec workspace php artisan view:clear
	docker-compose exec workspace php artisan config:cache
	docker-compose exec workspace php artisan route:cache
	docker-compose exec workspace npm run prod
	chmod -R 777 bootstrap/ storage/
```

## Обновление прода (подтянуть изменения)

Для этого действия у вас должен быть подключен  и доступен внешний git репозиторий с именем origin

```bash
make update-prod
```

## Работа с Docker

Эта дока не то чтобы сделает из вас Docker-гуру, но вы сможете что то поправить на проде без Миши. Большая часть ваших действий - это либо изменить конфиг, закоммитить и что то ребутнуть на проде, либо поменять настройки в `.env` и тоже как то ребутнуть что нибудь.

Мы используем Docker Compose. Это означает, что в файле `docker-compose.yml` определяются службы приложения. Службами являются:
- **caddy** - веб сервер (вместо nginx)
- **php-fpm** - пыха
- **workspace** — здесь у нас composer, node, cron
- **php-worker** - воркер, необходимый для работы очередей
- **mysql** - угадайте
- **postgress** - угадайте

Каждая службы может иметь один или несколько контенеров, связанных через переменные окружения, порты и вольюмы. При использовании Docker Compose (DC) вы можете оперировать как службами, так и контейнерами. Службами удобнее.

Сокращенные команды для Docker (устанавливаются с помощью [BDSM](https://github.com/michaelradionov/bdsm))

- `dc` = `docker-compose`
- `dew` = `docker-compose exec workspace`
- `dewpa` = `docker-compose exec workspace php artisan`
- `dewmfs` = `docker-compose exec workspace php artisan migrate:fresh --seed`

### Просмотр

```bash
dc ps # выводит список контейнеров для данного проекта (надо выполнять в директории проекта, где docker-compose.yml)
dps # выводит список всех запущенных в системе контейнеров (полезно, чтобы узнать, какой проект запущен на сервере или чекнуть контейнеры, не переходя в директорию проекта)
dc logs -f --tail=1000 # выводит логи всех служб
dc logs -f --tail=1000 php-fpm # выводит логи службы php-fpm
```

### Выполнение команд в контейнерах

```bash
dc exec php-fpm bash # войти в контенер службы php-fpm
dc exec mysql mysql -u<user> -p<password> # войти в контенер mysql и сразу войти в консоль mysql, например, на локале: dc exec mysql mysql -uroot -psecret
dew npm i # выполнение npm i в контейнере workspace
dew bash # войти в контенер в интерактивном режиме (Bash)
```

### Запуск проекта

При запуске проекта можно не указывать все необходимые службы, так как они опираются друг на друга. Службы **workspace** и **php-fpm** поднимутся автоматически при выполнении команды

```bash
dc up -d caddy mysql
```

Службу php-worker на момент написания доки надо указывать отдельно.

### Перезапуск контейнеров (для применения изменений в конфигах)

Тут все довольно интересно. Некоторые конфиги прокинуты в контейнеры через вольюмы, некоторые прокидываются при билде контейнера. Поэтому иногда изменения в конфигах применяются после перезапуска контейнера, иногда после пересборки, а ногда после обоих действий. Пока давайте будем рассматривать общий случай с пересборкой и рестартом.

```bash
dc up --build --no-deps --force-recreate -d caddy # билдит и поднимает контейнер службы caddy, но не рестартит его. и не трогает зависимые контейнеры
dc restart caddy # рестартит php-fpm
```

В общем случае этих двух команд должно хватить для применения конфигов.

### Конфиги

```bash
.env # единственный конфиг не под Git'ом, поэтому м нем хранятся все настройки сайта и докера
docker/php-fpm/xlaravel.pool.conf # php-fpm
docker/php-fpm/php7.2.ini # php
docker/caddy/caddy/conf/Caddyfile_production # Caddy продакшен
docker/mysql/my.cnf # mysql
docker/php-worker/supervisord.d/pullkins.conf # supervisor (хз почему называется pullkins в старых проектах, в сборке исправил на laraflag)
docker/workspace/crontab/laradock # cron (тоже в сборке уже laraflag)
```


### Чистка

Очень много места могут занимать неиспользуемые образы. Немного места могу занимать убитые контейнеры. Давайте удалим их все.

```bash
docker image prune
docker container prune
```



## Требования к серверу

### Программное обеспечение

- Ubuntu 16.04+
- Доступ по SSH с правами root

### Ресурсы

- RAM 2+ Гб
- CPU 1+ core 2+ Ггц
- Дисковое пространство 20+ Гб

### Сторонние сервисы

- Сервис отправки почты: Mailgun, SMTP или другие

## Требования к клиенту (средствам просмотра)

Сайт должен корректно отображаться в браузерах
- Google Chrome 69+
- Mozilla Firefox 62+
- Microsoft Edge 41+
- Opera 60.0+
- Яндекс.Браузер 18+
Сайт должен корректно работать как на устройствах с широкоэкранным монитором, так и на мобильных устройствах и планшетах с разрешением не ниже 1136 x 640 пикселей.
Сайт должен корректно отображаться при просмотре в масштабе 100%, другие масштабы на усмотрение Исполнителя.
Исполнитель не гарантирует валидность HTML и CSS.
