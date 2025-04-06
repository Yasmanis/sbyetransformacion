<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}