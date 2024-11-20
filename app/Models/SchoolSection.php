<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSection extends Model
{
    protected $fillable = ['name', 'description'];
    public function topics()
    {
        return $this->hasMany(SchoolTopic::class, 'section_id')->orderBy('order');
    }

    protected static function booted()
    {
        static::deleting(function ($section) {
            foreach ($section->topics as $t) {
                $t->deleteResourceFromDisk();
            }
        });
    }
}
