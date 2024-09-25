<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return Role::class;
    }

    public function component()
    {
        return 'roles/list';
    }
}
