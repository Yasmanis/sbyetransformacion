<?php

namespace App\Models;

use App\Traits\NotesInModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class Section extends Model
{
    use HasFactory;

    public function scopefilterByRegex($query, $regex)
    {
        return $query->where('name', 'like', '%' . $regex . '%');
    }
}