<?php

namespace App\Repositories;

use App\Models\ProductOffer;

class OfferRepository extends BaseRepository
{
    public function model()
    {
        return ProductOffer::class;
    }

    public function component()
    {
        return 'products/offers_component';
    }
}
