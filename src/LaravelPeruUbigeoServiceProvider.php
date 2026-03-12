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
        $this->publishes([
            __DIR__ . '/../config/ubigeo.php' => config_path('ubigeo.php'),
        ], 'ubigeo-config');
    }
}
