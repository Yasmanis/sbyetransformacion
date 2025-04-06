<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository extends BaseRepository
{
    public function model()
    {
        return City::class;
    }

    public function component()
    {
        return 'cities/list';
    }
}