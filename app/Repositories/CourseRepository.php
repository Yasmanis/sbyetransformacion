<?php

namespace App\Repositories;

use App\Models\Module;

class CourseRepository extends BaseRepository
{
    public function model()
    {
        return Module::class;
    }

    public function component()
    {
        return 'courses/list';
    }

    protected $scopes = [
        [
            'method' => 'school',
            'args' => null
        ]
    ];
}
