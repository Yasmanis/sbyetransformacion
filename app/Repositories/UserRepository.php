<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function component()
    {
        return 'users/list';
    }

    protected $with = ['books', 'books.attachments'];
}
