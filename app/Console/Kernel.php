<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Registrar aquí los comandos que crees
use App\Console\Commands\SyncErpClients;

class Kernel extends ConsoleKernel
{
    /**
     * Lista de comandos Artisan disponibles.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        SyncErpClients::class,
    ];

    /**
     * Definir tareas programadas (cron). Por ahora vacío.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Registrar comandos para Artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
