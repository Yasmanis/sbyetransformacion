<?php

namespace App\Repositories;

use App\Models\BillingInformation;

class BillingInformationRepository extends BaseRepository
{
    public function model()
    {
        return BillingInformation::class;
    }

    public function component()
    {
        return null;
    }
}