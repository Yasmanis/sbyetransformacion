<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushMessage extends Model
{
    protected $table = 'push_messages';

    protected $fillable = ['title'];
}
