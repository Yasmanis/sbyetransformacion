<?php

namespace App\Traits;

use App\Models\Note;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RowNote
{
    public function initializeRowNote(): void
    {
        $this->appends[] = 'row_note';
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function getRowNoteAttribute()
    {
        $user = auth()->user();
        if ($user) {
            return $this->notes()->firstWhere('user_id', $user->id);
        }
        return null;
    }
}
