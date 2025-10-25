<?php

namespace App\Repositories;

use App\Models\ProductCategoryOffer;

class ProductCategoryOfferRepository extends BaseRepository
{
    public function model()
    {
        return ProductCategoryOffer::class;
    }

    public function component()
    {
        return null;
    }
}
