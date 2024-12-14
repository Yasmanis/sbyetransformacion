<?php

namespace App\Repositories;

use App\Models\Testimony;

class TestimonyRepository extends BaseRepository
{
    public function model()
    {
        return Testimony::class;
    }

    public function component()
    {
        return 'testimony/list';
    }

    protected $with = ['user'];
}
