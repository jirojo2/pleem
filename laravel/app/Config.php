<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';

    protected $fillable = ['registration_enabled', 'countdown'];

    protected $casts = [
        'registration_enabled' => 'boolean',
    ];
}
