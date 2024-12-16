<?php

namespace App\Console\Commands;


use Carbon\Carbon;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackupDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup_db:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup diaria de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        set_time_limit(0);
        ini_set('memory_limit', '8912M');
        $now = Carbon::now()->toDateString() . '-' . Carbon::now()->timestamp;
        $db = env('DB_DATABASE', 'forge');
        $user = env('DB_USERNAME', 'forge');
        $pass = env('DB_PASSWORD', '');

        $backupPath = storage_path('backup');

        // Verifica si el directorio existe, si no, créalo
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        try {
            $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=' . $db, $user, $pass);
            $dump->start($backupPath . '/dump-' . $now . '.sql');
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
            return;
        }

        Log::info('Backup guardado correctamente.');

        $date = Carbon::now()->subDays(16)->toDateString();
        $oldBackupFile = $backupPath . '/dump-' . $date . '.sql';

        // Eliminar backups antiguos
        if (file_exists($oldBackupFile)) {
            unlink($oldBackupFile);
            Log::info('Backup antiguo eliminado: ' . $oldBackupFile);
        }

    }
}
