<?php

namespace App\Repositories;

use App\Models\BriefIdea;
use App\Models\Message;

class MessageRepository extends BaseRepository
{
    public function model()
    {
        return Message::class;
    }

    public function component()
    {
        return 'messages/list';
    }

    protected $with = ['assigned'];
}