<?php

namespace App\Repositories;

use App\Models\BriefIdea;

class BriefIdeaRepository extends BaseRepository
{
    public function model()
    {
        return BriefIdea::class;
    }

    public function component()
    {
        return 'pushmessages/list';
    }
}