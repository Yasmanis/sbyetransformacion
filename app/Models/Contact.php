<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'email', 'book_number', 'book_date', 'msg_title', 'message', 'other_people', 'ticket'];
}
