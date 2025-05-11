<?php

namespace App\Repositories;

use App\Models\Shopping;

class ShoppingRepository extends BaseRepository
{
    public function model()
    {
        return Shopping::class;
    }

    public function component()
    {
        return 'shopping/shopping';
    }
}
