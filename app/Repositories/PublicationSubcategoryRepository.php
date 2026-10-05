<?php

namespace App\Repositories;

use App\Models\PublicationSubcategory;

class PublicationSubcategoryRepository extends BaseRepository
{
    public function model()
    {
        return PublicationSubcategory::class;
    }

    public function component()
    {
        return 'files/subcategories';
    }
}
