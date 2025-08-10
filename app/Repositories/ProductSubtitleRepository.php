<?php

namespace App\Repositories;

use App\Models\ProductSubtitle;

class ProductSubtitleRepository extends BaseRepository
{
    public function model()
    {
        return ProductSubtitle::class;
    }

    public function component()
    {
        return null;
    }
}
