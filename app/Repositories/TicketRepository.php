<?php

namespace App\Repositories;

use App\Models\ContactAdmin;

class TicketRepository extends BaseRepository
{
    public function model()
    {
        return ContactAdmin::class;
    }

    public function component()
    {
        return null;
    }
}
