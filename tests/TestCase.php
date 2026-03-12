<?php

namespace LaravelPeru\Ubigeo\Tests;

use LaravelPeru\Ubigeo\LaravelPeruUbigeoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelPeruUbigeoServiceProvider::class,
        ];
    }
}
