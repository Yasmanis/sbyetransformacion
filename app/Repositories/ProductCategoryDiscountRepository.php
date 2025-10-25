<?php

namespace App\Repositories;

use App\Models\ProductCategoryDiscount;

class ProductCategoryDiscountRepository extends BaseRepository
{
    public function model()
    {
        return ProductCategoryDiscount::class;
    }

    public function component()
    {
        return null;
    }
}
