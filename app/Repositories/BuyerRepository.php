<?php

namespace App\Repositories;

use App\Models\Buyer;

class BuyerRepository extends BaseRepository
{
    public function model()
    {
        return Buyer::class;
    }

    public function component()
    {
        return null;
    }
}
