<?php

namespace App\Repositories;

use App\Models\Note;

class NoteRepository extends BaseRepository
{
    public function model()
    {
        return Note::class;
    }

    public function component()
    {
        return null;
    }
}
