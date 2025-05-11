<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    protected $table = 'shopping';

    protected $fillable = ['amount'];

    public function products()
    {
        return $this->hasMany(ShoppingProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}