<?php

namespace App\Repositories;

use App\Models\Landing;

class LandingRepository extends BaseRepository
{
    public function model()
    {
        return Landing::class;
    }

    public function component()
    {
        return 'landings/list';
    }
}
