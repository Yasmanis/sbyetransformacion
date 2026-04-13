<?php

namespace App\Models;

use App\Traits\Recyclable;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        't_color',
        'b_color',
        'user_id',
        'notable_type',
        'notable_id',
        'content'
    ];

    public function notable()
    {
        return $this->morphTo();
    }
}
