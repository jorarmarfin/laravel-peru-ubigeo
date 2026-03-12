<?php

namespace LaravelPeru\Ubigeo\Models;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = 'ubigeos';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'description',
        'department',
        'province',
        'district',
        'code_reniec',
    ];
}
