<?php

namespace App\Repositories;

use App\Models\SchoolSection;

class SchoolSectionsRepository extends BaseRepository
{
    public function model()
    {
        return SchoolSection::class;
    }

    public function component()
    {
        return 'life/index';
    }

    protected $with = ['topics', 'topics.resources'];
}