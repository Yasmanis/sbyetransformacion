<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Subtitle extends Model
{
    protected $table = 'subtitles';

    protected $fillable = ['name', 'description', 'subtitlable_type', 'subtitlable_id'];

    public function subtitlable(): MorphTo
    {
        return $this->morphTo();
    }
}
