<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryNomenclature extends Model
{
    protected $table = 'categories_nomenclatures';

    protected $fillable = ['key', 'value'];
}
