<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ico'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
