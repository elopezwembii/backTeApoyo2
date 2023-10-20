<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\DatabaseBackUp'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Envia correo cuando los gasto alcanzan a los prepuestos
        $schedule->command('email:send-monthly-notifications')->when(function () {
         $today = now()->day;
         return $today == 1 || $today == 15 || $today == now()->endOfMonth()->day;
       });
    
          // Envía correo para alerta presupuesto 50% 80%
         $schedule->command('email:test')->daily();

        // Envía correo por inactividad
         $schedule->command('email:send-inactive-users')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
