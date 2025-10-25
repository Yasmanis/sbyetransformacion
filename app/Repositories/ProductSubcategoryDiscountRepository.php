<?php

namespace App\Repositories;

use App\Models\ProductSubcategoryDiscount;

class ProductSubcategoryDiscountRepository extends BaseRepository
{
    public function model()
    {
        return ProductSubcategoryDiscount::class;
    }

    public function component()
    {
        return null;
    }
}
