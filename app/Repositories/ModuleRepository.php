<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository extends BaseRepository
{
    public function model()
    {
        return Module::class;
    }

    public function component()
    {
        return 'modules/list';
    }
}
