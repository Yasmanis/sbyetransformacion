<?php

namespace App\Console\Commands\RecycleBin;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanOrphaned extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recycle-bin:clean-orphans-recyclables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'borrado de modelos borrados que no estan en la papelera';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $models = Module::where('recycle', true)->get();
        foreach ($models as $m) {
            $fullClassName = "\\App\\Models\\" . $m->model;
            if (!class_exists($fullClassName)) {
                $this->error("La clase {$fullClassName} no existe.");
                continue;
            }
            $modelInstance = new $fullClassName;
            $tableName = $modelInstance->getTable();
            $orphans = $fullClassName::onlyTrashed()
                ->whereNotExists(function ($query) use ($tableName, $modelInstance) {
                    $query->select(DB::raw(1))
                        ->from('recycle_bin')
                        ->whereColumn('recycle_bin.recyclable_id', $tableName . '.id')
                        ->where('recycle_bin.recyclable_type', $modelInstance::class);
                })
                ->get();

            foreach ($orphans as $orphan) {
                try {
                    $orphan->forceDelete();
                    $this->info("Eliminado huérfano de {$m->model} con ID: {$orphan->id}");
                } catch (\Throwable $th) {
                    $this->error("No se ha podido elimnar el huérfano de {$m->model} con ID: {$orphan->id}. Error: {$th->getMessage()}");
                }
            }
        }
    }
}
