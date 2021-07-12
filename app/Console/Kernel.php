<?php

namespace App\Console;

use App\Jobs\GenerateFines;
use App\Jobs\GenerateLoanFine;
use App\Jobs\GenerateLoanInterest;
use App\Jobs\GeneratePayments;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('telescope:prune --hours=72')->daily();
        $schedule->job(new GeneratePayments(now()))->monthly();
        $schedule->job(new GenerateFines(now()))->monthlyOn(16, '01:00');
        $schedule->job(new GenerateLoanInterest(now()))->dailyAt('00:10');
        $schedule->job(new GenerateLoanFine(now()))->dailyAt('00:20');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
