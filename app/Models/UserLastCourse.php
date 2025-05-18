<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLastCourse extends Model
{
    protected $table = 'users_last_courses';

    protected $fillable = [
        'category',
        'user_id',
        'section_id',
        'topic_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(SchoolSection::class, 'section_id');
    }

    public function topic()
    {
        return $this->belongsTo(SchoolTopic::class, 'topic_id');
    }
}
