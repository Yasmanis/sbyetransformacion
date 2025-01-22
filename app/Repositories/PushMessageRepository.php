<?php

namespace App\Repositories;

use App\Models\PushMessage;

class PushMessageRepository extends BaseRepository
{
    public function model()
    {
        return PushMessage::class;
    }

    public function component()
    {
        return 'pushmessages/list';
    }
}
