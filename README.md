# laravel-peru-ubigeo

Base package to work with Peruvian ubigeo data in Laravel.

## Installation

```bash
composer require luiscamp/laravel-peru-ubigeo
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

## Publish and run seeder

```bash
php artisan vendor:publish --tag=ubigeo-seeders
php artisan db:seed --class=UbigeoSeeder
```

## Testing

```bash
composer test
```
