<?php

namespace App\Console\Commands\RecycleBin;

use App\Models\RecycleBin;
use Illuminate\Console\Command;

class CleanAutoDeleted extends Command
{
    protected $signature = 'recycle-bin:clean-auto-deleted';
    protected $description = 'Eliminar permanentemente elementos expirados de la papelera';

    public function handle()
    {
        $count = RecycleBin::toAutoDelete()->count();
        RecycleBin::toAutoDelete()->delete();
        $this->info("Se eliminaron {$count} elementos de la papelera");
    }
}
