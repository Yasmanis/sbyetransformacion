<?php

namespace App\Traits;

use App\Models\RowConfig;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RowConfiguration
{

    public function initializeRowConfiguration(): void
    {
        $this->appends[] = 'row_config';
    }

    public function rowConfig(): MorphMany
    {
        return $this->morphMany(RowConfig::class, 'configable');
    }

    public function getRowConfigAttribute()
    {
        $user = auth()->user();
        if ($user) {
            return $this->rowConfig()->firstWhere('user_id', $user->id);
        }
        return null;
    }
}
