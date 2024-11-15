<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolUserVideo extends Model
{
    protected $table = 'school_users_videos';

    public $timestamps = false;

    protected $fillable = ['current_percentaje'];

    public function resource()
    {
        return $this->belongsTo(SchoolResource::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
