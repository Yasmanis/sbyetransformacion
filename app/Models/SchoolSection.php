<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSection extends Model
{
    protected $fillable = ['name'];
    public function topics()
    {
        return $this->hasMany(SchoolTopic::class, 'section_id')->orderBy('order');
    }
}