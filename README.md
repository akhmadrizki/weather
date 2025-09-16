# Code Test

> Based on [Laravel 12](https://laravel.com/docs/12.x)

## Table of contents

-   [Prerequisites](#prerequisites)
-   [Setup](#setup)
-   [Database setup](#database-setup)
-   [How To Try](#test)
-   [Package Usage](#this-project-using)
-   [API Documentation](https://e1yjsbmekf.apidog.io/)

## Prerequisites

-   PHP = 8.3^

## Setup

1. Clone this project

```sh
git clone https://github.com/akhmadrizki/weather.git
```

2. Copy file `.env.example` to `.env`:

```sh
cp env-example .env
```

3. Install all package

```sh
composer install
```

## Database setup

`use mysql driver`

```sh
...
DB_CONNECTION=mysql
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
...
```

Run this command:

```sh
php artisan key:generate
php artisan migrate:fresh --seed
```

you can try login with this credential

```
email: jhon@mail.com
password: secrect
```

If you want to run this project please run:

```sh
php artisan serve
```

Or if you using `Herd` `Laragon` `Valet`
you just type weather.test

## Test

this project is implement task schedule, so if you want to test

run this command:

```sh
php artisan queue:work
```

this for running the send welcome mail Job

Because this project has a weather API, which will be updated regularly every hour. If you want to run it, you can run the command below.

```sh
php artisan schedule:test
```

This project is using [weatherapi.com](https://www.weatherapi.com/)
the default I already input the credential key

Then for the city weather forecast options
the default is `Perth`
if you want to change another city, you can input the city name on `.env` file `WEATHER_DEFAULT_CITY=CityName`

This project also using PHPUnit for testing, if you want to run the test, you can run the command below.

```sh
php artisan test
```

## This Project Using

1. Larastan
    > this for make laravel code typing safe check

```sh
./vendor/bin/phpstan analyse
```

2. Laravel Pint
    > this for make laravel coding style

```sh
./vendor/bin/pint
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
