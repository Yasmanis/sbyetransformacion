<?php

namespace App\Repositories;

use App\Models\ProductSubcategoryOffer;

class ProductSubcategoryOfferRepository extends BaseRepository
{
    public function model()
    {
        return ProductSubcategoryOffer::class;
    }

    public function component()
    {
        return null;
    }
}
