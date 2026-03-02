<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'users_buyers';

    protected $fillable = [
        'user_id',
        'country_id',
        'city',
        'province',
        'postal_code',
        'road',
        'address',
        'genre',
        'phone',
        'phone_code',
        'birthdate'
    ];

    protected $appends = ['country_str', 'birthdate_str'];

    protected $casts = ['birthdate' => 'date'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getCountryStrAttribute()
    {
        return $this->country()->first()->name;
    }

    public function getBirthdateStrAttribute()
    {
        return $this->birthdate ? $this->birthdate->format('d/m/Y') : null;
    }
}
