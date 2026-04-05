<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function scopefilterByRegex($query, $regex)
    {
        return $query->where('name', 'like', '%' . $regex . '%');
    }
}
