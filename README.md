# laravel-peru-ubigeo

Base package to work with Peruvian ubigeo data in Laravel.

## Installation

```bash
composer require luiscamp/laravel-peru-ubigeo
```

## Quick start after install

```bash
# 1) Publish migration
php artisan vendor:publish --tag=ubigeo-migrations

# 2) Run migrations
php artisan migrate

# 3) Publish seeder
php artisan vendor:publish --tag=ubigeo-seeders

# 4) Seed ubigeo data
php artisan db:seed --class="Database\\Seeders\\UbigeoSeeder"
```

## Publish config

```bash
php artisan vendor:publish --tag=ubigeo-config
```

## Publish migrations

```bash
php artisan vendor:publish --tag=ubigeo-migrations
php artisan migrate
```

## Publish model + migration (single command)

```bash
php artisan ubigeo:publish
```

Options:
- `php artisan ubigeo:publish --model`
- `php artisan ubigeo:publish --migration`
- `php artisan ubigeo:publish --force`

## Publish and run seeder

```bash
php artisan vendor:publish --tag=ubigeo-seeders
php artisan db:seed --class="Database\\Seeders\\UbigeoSeeder"
```

## API endpoints

By default the prefix is `ubigeo` and middleware is `api`.

```bash
GET /ubigeo/search?code=010000
GET /ubigeo/search?name=lima
GET /ubigeo/departments?name=ama
GET /ubigeo/provinces/010000?name=chacha
GET /ubigeo/districts/010100?name=asuncion
```

Rules:
- Department code: ends with `0000` (example `010000`).
- Province code: ends with `00` and excludes departments (example `010100`).
- District responses return `id` (not `code`).

## Trait methods

```php
use LaravelPeru\Ubigeo\Traits\InteractsWithUbigeo;

class UbigeoService
{
    use InteractsWithUbigeo;
}
```

Available methods:
- `getDepartament(?string $name = null)`
- `getProvice(string $code, ?string $name = null)`
- `getDistrict(string $code, ?string $name = null)`

## Testing

```bash
composer test
```
