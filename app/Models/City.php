<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $state_id
 */
class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'country_id',
        'state_id'
    ];

    protected $appends = [
        'country_str',
        'state_str'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function getCountryStrAttribute()
    {
        return $this->country->name;
    }

    public function getStateStrAttribute()
    {
        return $this->state->name;
    }
}