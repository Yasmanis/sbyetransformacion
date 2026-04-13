<?php

namespace App\Traits;

use App\Models\RecycleBin;
use Illuminate\Database\Eloquent\SoftDeletes;

trait Recyclable
{
    use SoftDeletes;

    public static function bootRecyclable()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
                return;
            }
            $model->moveToRecycleBin();
        });
    }

    protected function moveToRecycleBin()
    {
        $daysToKeep = $this->recycleBinDays ?? 30;

        RecycleBin::create([
            'recyclable_type' => get_class($this),
            'recyclable_id' => $this->id,
            'title' => $this->getRecycleBinTitle(),
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'auto_delete_at' => now()->addDays($daysToKeep),
        ]);
    }

    protected function getRecycleBinTitle()
    {
        if (method_exists($this, 'getTitleForRecycleBin')) {
            return $this->getTitleForRecycleBin();
        }
        return $this->name ?? $this->title ?? "ID: {$this->id}";
    }

    public function restoreFromRecycleBin()
    {
        $this->restore();
    }
}
