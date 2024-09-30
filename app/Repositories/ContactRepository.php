<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository extends BaseRepository
{
    public function model()
    {
        return Contact::class;
    }

    public function component()
    {
        return null;
    }
}