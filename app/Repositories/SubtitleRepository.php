<?php

namespace App\Repositories;

use App\Models\Subtitle;

class SubtitleRepository extends BaseRepository
{
    public function model()
    {
        return Subtitle::class;
    }

    public function component()
    {
        return null;
    }
}
