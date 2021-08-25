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

# Запуск проекта

- cp .env.example .env
- В конфиге настраиваем подключение к базе
- Удалить службы из docker-compose.yml, которые вам не нужны, например mysql
- dc up -d
- dc exec app composer i
- dc exec app npm i
- dc exec app npm run dev
- pa migrate --seed
- pa key:generate

***
***

# Laraflag Porto

## Введение

[Здесь][1] можно почитать про концепцию Porto от его создателя. А [это][2] его собственная реализация Porto на laravel. Можно развирнуть и потыкать при желании. Или просто подстмотреть что-то и взять к себе в проект.

[1]: https://github.com/Mahmoudz/Porto
[2]: https://github.com/apiato/apiato

В сборке предполагается использование подхода TDD при разработке. Поэтому тесты настроены, чтобы они запускались у каждого контейнера и корабля. Есть список контейнеров необходимых для всех проектов:
- Пользователь (CRUD)
- Аутентификация (registration, login, logout, refresh token)
- Авторизация (не сделано пока)
- Настройки (настройки сайта + редиректы)
- Robots (очевидно)

***

## Концепция

В Porto приложение делится на два слоя: контейнеры и корабль. Слой корабля отвечает за логику приложения, а контейнеры(они же домены/модули) отвечают за бизнес логику. Один контейней в 99% случаев обслуживает только одну модель. Могут быть исключения, когда вторая модель логически нам не нужна в отрыве от первой, тогда их можно сложить в один контейнер. Если же предпологается, что со второй моделью будут выполняться операции CRUD(хотя бы одна из них), тогда только отдельный контейнер. Все компоненты контейнеров должны наследоваться только от классов из коробля(Ship/Parents/*).
В Porto ещё допускается объединение нескольких контейнеров в однин раздел (section) - <span style="color:red">__не реализовано__</span>. Это допускается если контейнеры имеют связи между собой. Например таким образом мы может объединить в один раздел пользователя, аутентификацию и авторизацию.

> Контейнер может содержать в себе связи с компонентами других контейнеров, но только через специальный интерфейс в виде фасада (<span style="color:red">__не реализовано__</span>)

***

## Слой контейнера

Подробнее рассмотрим из чего состоит контейнер:
```
Container
        ├── Actions
        ├── Commands
        ├── Configs
        ├── Domain
        |        ├── Сriterias (__не реализовано__)
        |        ├── Entities
        |        ├── Enums
        |        ├── Factories
        |        ├── Migrations
        |        ├── Policies
        |        ├── Repositories
        |        ├── Seeders (__не реализовано__)
        |        └── Values (__не реализовано__)
        ├── Events
        ├── Exceptions
        ├── Http
        |        ├── Controllers
        |        ├── Middlewares
        |        └── Requests
        ├── Jobs
        ├── Listeners
        ├── Mails
        ├── Nova
        |        ├── Actions
        |        ├── Filters
        |        └── Resources
        ├── Notifications
        ├── Providers
        ├── Routes
        ├── Tasks
        ├── Tests
        |        ├── Feature
        |        └── Unit
        └── Transfers
                ├── Resources
                ├── Responders
                └── Transporters
```

### Action

<a id="Action"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Сюда мы выносим всю логику из контроллера. Один класс - одно действие. Список actions должен полностью отображать, что может делать контейнер. 
> Например, если мы может получить профиль пользователя, то для этого у нас будет отдельный action.

Action в себе содержит только один метод `public function run(Transporter $transporter) {}`, который на вход принимает класс наследник `Transporter` из контроллера. Структура action должна быть предельно ленейной минимум ветвлений `if` или `switch`. Его содержание долно просто читаться сверху вниз. Также кроме метода `run` ничего быть не должно. Всю свою работу `action` дилегирует в `task-и`. 

```php
namespace App\Containers\User\Actions;

use ...

class UserUpdateAction extends Action
{
    public function run(UserUpdateTransporter $fields)
    {
        try {
            $this->task(UserUpdateTask::class, [$fields->toArray()]);

            return $this->responder(UserUpdatedResponder::class);
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}
```

Весь код `action` должен обрамляться блоком `try`, т.е. он должен обрабатывать все возникающие исключения дальше по иерархии. До контроллера не должно доходить никаких иселючений, т.к. он отвечает только за получение запроса и отдачу ответа.

`Action` может вызвать `Task`, `Responder`, `SubAction`. Также он сам может быть вызван из `Controller`, `Command`, `Listener`, `Job`.

***

</Details>

### Commands

Содержат необходимые команды для работы контейнера. Команды могут вызывать `Action-ы`

### Configs

Содержат необходимые конфиги для работы контейнера

### Criterias (__не реализовано__)

//TODO

### Entities

Здесь лежат наши модели, но разобранные на части. Кучи констант в id-ами вынесены в `Enum-ы`, запросы к базе делаются через `Repository`, скоупы для запросов убираютсяв `Criteria`, а сложное сохранение и получение свойств должно быть в `Value`.

### Enums

<a id="Enums"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Хранит набор данных вида ключ-значение:

```php
namespace App\Containers\User\Domain\Enums\Sex;

use App\Ship\Parents\Enum\Enum;

/**
 * @method static self man()
 * @method static self woman()
 */
class SexEnum extends Enum
{
    public static function labels(): array
    {
        return [
            'man' => 0,
            'woman' => 1,
            'other' => 2,
        ];
    }
}
```

***

</Details>

### Repositories

<a id="Repositories"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

На данный момент это просто класс, который в себе хранит набор запросов, которые можно использовать в разных местах в коде без повторений.

```php
namespace App\Containers\User\Domain\Repositories;

use ...

class UserRepository extends Repository
{
    ...

    public function getByPhone(string $phone)
    {
        return User::wherePhone($phone)->first();
    }
    
    ...
}
```

***

</Details>

### Seeders (__не реализовано__)

//TODO
Сейчас сиды лежат в обычном месте

### Values (__не реализовано__)

//TODO

### Controllers

Контроллер принимает `Request` и вызывает `Action`. Формирование правильного ответа занимается `Action`. Контроллер не может вызывать компоненты ниже `Action` в иерархии.

### Requests

<a id="Requests"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Обычный реквест, но с добавлением `Transporter` (DTO). это позволяем достать из запроса отвалидированные данные в видео объекта и быть уверенным, что все необходимые данные (свойства класса DTO) будут нам доступны в правильном наборе. В запросе указываем в методе `transporter()` `namespace` нашего транспортера:

```php
namespace App\Containers\User\Http\Requests;

use ...

class UserUpdateRequest extends Request
{
    ...

    public function transporter(): string
    {
        return UserUpdateTransporter::class;
    }

    ...
}
```

Затем в контроллере достаём эти данные из запроса, вызовом метода `transportered()`:

```php
namespace App\Containers\User\Http\Controllers;

use ...

class UserController extends Controller
{
    ...

    public function update(UserUpdateRequest $request)
    {
        return $this->action(
            UserUpdateAction::class,
            $request->transportered(),
        );
    }
    
    ...
}
```

И дальше в `Action` мы принимаем не какой-то массив, с неясным набором полей, а конкретный экземпляр класса, где может быть точно уверены, что данные там есть:

```php
namespace App\Containers\User\Actions;

use ...

class UserUpdateAction extends Action
{
    public function run(UserUpdateTransporter $fields)
    {
        //code...
    }
}
```

***

</Details>

### Nova

`Resource`, `Action` и `Filter` помещаются внутри контейнера поближе к домену.

### Routes

Рауты делятся на два вида `api` и `web`, как и у Laravel. Но теперь они помещены в каждый контейнер и хранятся отдельно от других.

### Tasks

<a id="Requests"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Задачи - это класс, который не содержит в себе бизнес логику. В нём хранится линь маленькое унарное действие. Они нужны для убирания дублирования из нашего кода. их использование не обязательно в `Action-ах`, однако проще сразу вынести какую-то операцию в `Task` и переиспользовать при необходимости, чем потом искать все места и заменять на `Task-и`. 
`Task` может работать с моделью либо её репозиторием и не вызывать компонемны вышего него по иерархии. Его могет вызывать только `Action` и `SubAction`

```php
namespace App\Containers\User\Tasks;

use ...

class FindUserByPhoneTask extends Task
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $phone)
    {
        try {
            return $this->repository->getByPhone($phone);
        } catch (\Exception $e) {
            throw new UserNotFoundException;
        }
    }
    
    ...
}
```

***

</Details>

### Tests

Тесты для проверки функциональнсти контейнера

### Transfers

DTO объекты

### Resources

[API Resources](https://laravel.com/docs/8.x/eloquent-resources)

### Responders

//TODO перенести в Http
Принимает данные, которые упаковывает либо во `view`, либо в виде `json response`

### Transporters

<a id="Requests"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Преобразует отвалидированные данные из запроса в объект DTO. Для его использования достаточно создать класс транспортера используя команду в консоли `php artisan flag:transporter`. Затем добавить в класс закроса в методе `transporter()`

```php
namespace App\Containers\User\Transfers\Transporters;

use ...

class UserUpdateTransporter extends Transporter
{
    public string $name;
    public string $phone;
    public string $email;
    public string $birth;
    public bool $allow_ads;

    public static function castKeys(): array
    {
        return [
            'birthday' => 'birth',
            'offers' => 'allow_ads',
        ];
    }
}
```

```php
namespace App\Containers\User\Http\Requests;

use ...

class UserUpdateRequest extends Request
{
    public function transporter(): string
    {
        return UserUpdateTransporter::class;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'phone' => 'nullable|numeric|regex:/\+79[0-9]{9}/',
            'email' => 'nullable|email',
            'birthday' => 'nullable|date',
            'offers' => 'nullable|boolean',
        ];
    }
}
```

Можно заметить, что у транспортера усть метод `castKeys()`. Он нужет для приведение ключей из запроса к нужному виду нам дальше в приложении. 

***

</Details>
