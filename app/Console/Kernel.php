<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

         //$schedule->command('inspire')->everyMinute()->sendOutputTo("task-output.log");

       //  $schedule->command('app:task-command')->everyMinute()->sendOutputTo("tasks-output-task-command.log");


        // $schedule->call(function () {
        //     // wherenull kaj so ovaa kolona e null
        //    // User::whereNull('email_verified_at')->delete();
        // })->everyMinute();

        $schedule->command('email:send')->everyMinute();
        // $schedule->command('email:send')->everyFiveMinutes(); // na 5 min 
        // $schedule->command('email:send')->hourly();

        // $schedule->command('email:send')->weekdays()->hourly()->timezone('Skopje')->between('8:00', '17:00');


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
