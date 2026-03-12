<?php

namespace LaravelPeru\Ubigeo\Tests;

use LaravelPeru\Ubigeo\LaravelPeruUbigeoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelPeruUbigeoServiceProvider::class,
        ];
    }
}
