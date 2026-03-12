<?php

namespace LaravelPeru\Ubigeo;

use Illuminate\Support\ServiceProvider;
use LaravelPeru\Ubigeo\Console\Commands\PublishUbigeoResourcesCommand;

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

        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishUbigeoResourcesCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/ubigeo.php' => config_path('ubigeo.php'),
            ], 'ubigeo-config');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'ubigeo-migrations');

            $this->publishes([
                __DIR__ . '/../database/seeders/UbigeoSeeder.php' => database_path('seeders/UbigeoSeeder.php'),
            ], 'ubigeo-seeders');

            $this->publishes([
                __DIR__ . '/../stubs/Ubigeo.php' => app_path('Models/Ubigeo.php'),
            ], 'ubigeo-model');
        }
    }
}
