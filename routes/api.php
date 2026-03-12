<?php

use Illuminate\Support\Facades\Route;
use LaravelPeru\Ubigeo\Http\Controllers\UbigeoController;

Route::group([
    'prefix' => config('ubigeo.route_prefix', 'ubigeo'),
    'middleware' => config('ubigeo.route_middleware', ['api']),
], function (): void {
    Route::get('/search', [UbigeoController::class, 'search'])->name('ubigeo.search');
    Route::get('/departments', [UbigeoController::class, 'departments'])->name('ubigeo.departments');
    Route::get('/provinces/{code}', [UbigeoController::class, 'provinces'])->name('ubigeo.provinces');
    Route::get('/districts/{code}', [UbigeoController::class, 'districts'])->name('ubigeo.districts');
});
