<?php

namespace LaravelPeru\Ubigeo;

use Illuminate\Support\ServiceProvider;

class LaravelPeruUbigeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ubigeo.php', 'ubigeo');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/ubigeo.php' => config_path('ubigeo.php'),
        ], 'ubigeo-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'ubigeo-migrations');

        $this->publishes([
            __DIR__ . '/../database/seeders/UbigeoSeeder.php' => database_path('seeders/UbigeoSeeder.php'),
        ], 'ubigeo-seeders');
    }
}
