<?php

namespace App\Repositories;

use App\Models\Campaign;

class CampaignRepository extends BaseRepository
{
    public function model()
    {
        return Campaign::class;
    }

    public function component()
    {
        return 'campaigns/list';
    }
}
