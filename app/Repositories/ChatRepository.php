<?php

namespace App\Repositories;

use App\Models\SchoolChat;

class ChatRepository extends BaseRepository
{
    public function model()
    {
        return SchoolChat::class;
    }

    public function component()
    {
        return 'chats/list';
    }
}
