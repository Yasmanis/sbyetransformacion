<?php

namespace App\Repositories;

use App\Models\PushMessage;

class PushMessageRepository extends BaseRepository
{
    public function __construct()
    {
        $this->makeModel();
        $segment = last(request()->segments());
        if (($segment && $segment === 'briefideas') || !auth()->user()->sa) {
            $this->scopes = [array(
                'method' => 'active',
                'args' => null
            ), array(
                'method' => 'publicated',
                'args' => null
            )];
        }
    }

    public function model()
    {
        return PushMessage::class;
    }

    public function component()
    {
        return 'pushmessages/list';
    }
}
