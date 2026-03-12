<?php

namespace LaravelPeru\Ubigeo\Tests\Feature;

use LaravelPeru\Ubigeo\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_package_config_is_loaded(): void
    {
        $this->assertNull(config('ubigeo.source'));
    }
}
