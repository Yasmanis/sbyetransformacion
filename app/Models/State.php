<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $country_id
 */
class State extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'country_id'
    ];

    protected $appends = [
        'country_str'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function getCountryStrAttribute()
    {
        return $this->country->name ?? null;
    }
}