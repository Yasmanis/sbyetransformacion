<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonForReturn extends Model
{
    use HasFactory;

    protected $table = 'reason_for_return';

    protected $fillable = ['name'];
}