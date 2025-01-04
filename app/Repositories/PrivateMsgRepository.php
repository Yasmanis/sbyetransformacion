<?php

namespace App\Repositories;

use App\Models\PrivateMsg;

class PrivateMsgRepository extends BaseRepository
{
    public function model()
    {
        return PrivateMsg::class;
    }

    public function component()
    {
        return null;
    }
}
