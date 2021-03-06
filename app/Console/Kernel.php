<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\d_desc_pro::class,
        Commands\SendMailContract::class,
        Commands\InsertJornalPacking::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->command('divide:proveedor')
            ->daily();
        $schedule->command('alert:ContractDefeated')
            ->daily();
        $schedule->command('process:insert_jornal_packing')
            ->daily();
    }
}
