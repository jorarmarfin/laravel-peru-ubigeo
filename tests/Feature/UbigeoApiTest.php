<?php

namespace LaravelPeru\Ubigeo\Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelPeru\Ubigeo\Tests\TestCase;

class UbigeoApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('ubigeos');
        Schema::create('ubigeos', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 10)->index();
            $table->string('description')->index();
            $table->string('department');
            $table->string('province');
            $table->string('district');
            $table->string('code_reniec', 10)->nullable()->index();
        });

        DB::table('ubigeos')->insert([
            [
                'code' => '010000',
                'description' => 'AMAZONAS/AMAZONAS/AMAZONAS',
                'department' => 'AMAZONAS',
                'province' => 'AMAZONAS',
                'district' => 'AMAZONAS',
                'code_reniec' => '010000',
            ],
            [
                'code' => '010100',
                'description' => 'AMAZONAS/CHACHAPOYAS/CHACHAPOYAS',
                'department' => 'AMAZONAS',
                'province' => 'CHACHAPOYAS',
                'district' => 'CHACHAPOYAS',
                'code_reniec' => '010100',
            ],
            [
                'code' => '010101',
                'description' => 'AMAZONAS/CHACHAPOYAS/CHACHAPOYAS',
                'department' => 'AMAZONAS',
                'province' => 'CHACHAPOYAS',
                'district' => 'CHACHAPOYAS',
                'code_reniec' => '010101',
            ],
            [
                'code' => '010102',
                'description' => 'AMAZONAS/CHACHAPOYAS/ASUNCION',
                'department' => 'AMAZONAS',
                'province' => 'CHACHAPOYAS',
                'district' => 'ASUNCION',
                'code_reniec' => '010102',
            ],
        ]);
    }

    public function test_departments_endpoint_returns_department_codes(): void
    {
        $response = $this->getJson('/ubigeo/departments');

        $response
            ->assertOk()
            ->assertJsonPath('type', 'department')
            ->assertJsonFragment(['code' => '010000'])
            ->assertJsonMissing(['code' => '010100']);
    }

    public function test_provinces_endpoint_excludes_department_codes(): void
    {
        $response = $this->getJson('/ubigeo/provinces/010000');

        $response
            ->assertOk()
            ->assertJsonPath('type', 'province')
            ->assertJsonFragment(['code' => '010100'])
            ->assertJsonMissing(['code' => '010000']);
    }

    public function test_districts_endpoint_returns_id_and_not_code(): void
    {
        $response = $this->getJson('/ubigeo/districts/010100');

        $response
            ->assertOk()
            ->assertJsonPath('type', 'district');

        $firstDistrict = $response->json('data.0');

        $this->assertIsArray($firstDistrict);
        $this->assertArrayHasKey('id', $firstDistrict);
        $this->assertArrayNotHasKey('code', $firstDistrict);
    }

    public function test_search_by_district_code_returns_district_type_with_id(): void
    {
        $response = $this->getJson('/ubigeo/search?code=010101');

        $response
            ->assertOk()
            ->assertJsonPath('type', 'district');

        $firstDistrict = $response->json('data.0');

        $this->assertIsArray($firstDistrict);
        $this->assertArrayHasKey('id', $firstDistrict);
        $this->assertArrayNotHasKey('code', $firstDistrict);
    }
}
