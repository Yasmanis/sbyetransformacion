<?php

namespace App\Repositories;

use App\Models\ReasonForReturn;

class ReasonForReturnRepository extends BaseRepository
{
    public function model()
    {
        return ReasonForReturn::class;
    }

    public function component()
    {
        return 'reasons_for_return/list';
    }
}