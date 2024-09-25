<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository extends BaseRepository
{
    public function model()
    {
        return File::class;
    }

    public function component()
    {
        return 'files/list';
    }
}
