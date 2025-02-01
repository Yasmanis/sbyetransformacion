<?php

namespace App\Repositories;

use App\Models\CategoryNomenclature;

class SectionRepository extends BaseRepository
{
    public function model()
    {
        return CategoryNomenclature::class;
    }

    public function component()
    {
        return 'sections/list';
    }
}