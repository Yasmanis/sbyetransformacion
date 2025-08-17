<?php

namespace App\Repositories;

use App\Models\ProductDiscount;

class DiscountRepository extends BaseRepository
{
    public function model()
    {
        return ProductDiscount::class;
    }

    public function component()
    {
        return null;
    }
}
