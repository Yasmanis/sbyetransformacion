<?php

namespace App\Repositories;


use App\Models\RecycleBin;

class RecycleBinRepository extends BaseRepository
{
    public function model()
    {
        return RecycleBin::class;
    }

    public function component()
    {
        return 'recycle_bin/list';
    }
}
