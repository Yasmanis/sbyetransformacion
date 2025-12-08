<?php

namespace App\Repositories;

use App\Models\TiketReply;

class TiketReplyRepository extends BaseRepository
{
    protected $with = ['files'];
    public function model()
    {
        return TiketReply::class;
    }

    public function component()
    {
        return null;
    }
}
