<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $phonecode
 * @property array $timezones
 */
class Country extends Model
{
    protected $fillable = [
        'id',
        'name',
        'phonecode',
        'timezones'
    ];

    protected $casts = [
        'timezones' => 'array'
    ];
}