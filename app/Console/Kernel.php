<?php

namespace App\Console;

use App\Console\Commands\BroadCastUsuariosActivosCount;
use App\Console\Commands\ConsultarRepsCachados;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ConsultarRepsCachados::class,
        BroadCastUsuariosActivosCount::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //$schedule->command('reps:consultar-cachados')->dailyAt('04:00');
        $schedule->command('broadcast:usuarios-activos-count')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
