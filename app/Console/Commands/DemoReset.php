<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DemoReset extends Command
{
    protected $signature = 'demo:reset
                            {--force : Salta la richiesta di conferma (usare in cron)}';

    protected $description = 'Ripristina il database demo e cancella i file caricati dagli utenti.';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->warn('⚠️  Questa operazione cancellerà TUTTI i dati del database e i file caricati.');
            if (! $this->confirm('Sei sicuro di voler continuare?')) {
                $this->info('Operazione annullata.');
                return self::SUCCESS;
            }
        }

        $this->info('[1/3] Eliminazione file allegati...');
        $this->deleteStorageDirectory('attachments');

        $this->info('[2/3] Eliminazione loghi aziende...');
        $this->deleteStorageDirectory('public/logos');

        $this->info('[3/3] Reset database e seed...');
        $this->call('migrate:fresh', [
            '--seed'  => true,
            '--force' => true,
        ]);

        $this->newLine();
        $this->info('✅  Demo ripristinato con successo.');

        return self::SUCCESS;
    }

    /**
     * Elimina tutti i file dentro una cartella dello storage
     * preservando la directory stessa e i file .gitkeep.
     */
    private function deleteStorageDirectory(string $directory): void
    {
        $disk = Storage::disk('local');

        if (! $disk->exists($directory)) {
            $this->line("   Cartella «{$directory}» non trovata, skip.");
            return;
        }

        // Elimina ricorsivamente tutti i file (non le directory vuote)
        $files = $disk->allFiles($directory);
        $deleted = 0;

        foreach ($files as $file) {
            // Preserva i file .gitkeep usati per mantenere la struttura in git
            if (str_ends_with($file, '.gitkeep')) {
                continue;
            }

            $disk->delete($file);
            $deleted++;
        }

        // Elimina le sotto-directory vuote create dagli upload
        foreach ($disk->allDirectories($directory) as $dir) {
            $disk->deleteDirectory($dir);
        }

        $this->line("   {$deleted} file eliminati da «{$directory}».");
    }
}
