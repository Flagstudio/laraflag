<?php

namespace App\Ship\Kernels;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class ConsoleKernel extends Kernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if ($this->app->isLocal() || mb_strtolower(app()->environment()) === 'dev') {
            $schedule->command('telescope:prune')->cron('0 23 */2 * *');
        }

        $schedule->command('import:currencies')->dailyAt('04:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(ship_path('Apiato/Console'));

        $this->load(container_path(''));

        require base_path('routes/console.php');
    }
}
