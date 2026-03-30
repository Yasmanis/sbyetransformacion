<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RowConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'configable_type',
        'configable_id',
        'highlighteds_columns'
    ];

    protected $casts = ['highlighteds_columns' => 'json'];

    public function configable(): MorphTo
    {
        return $this->morphTo();
    }
}
