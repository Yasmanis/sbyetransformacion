<?php

namespace App\Repositories;

use App\Models\SchoolTopic;

class SchoolTopicRepository extends BaseRepository
{
    public function model()
    {
        return SchoolTopic::class;
    }

    public function component()
    {
        return null;
    }

    protected $with = ['resources', 'messages'];
}
