<?php

namespace App\Repositories;

use App\Models\Family;

class FamilyRepository extends BaseRepository
{
    public function model()
    {
        return Family::class;
    }

    public function component()
    {
        return null;
    }
}
