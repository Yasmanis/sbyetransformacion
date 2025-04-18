<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'users_buyers';

    protected $fillable = [
        'user_id',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'road',
        'address',
        'genre',
        'phone',
        'phone_code',
        'birthdate'
    ];

    protected $appends = ['permissions'];
}
