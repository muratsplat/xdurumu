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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Weather\UpdateCurrent::class,
        \App\Console\Commands\Weather\UpdateHourly::class,
        \App\Console\Commands\Weather\UpdateDaily::class,
        \App\Console\Commands\Weather\DeleteOldData::class
    ];   
    
    /**
     * How to use CRON
     * 
     * http://www.cyberciti.biz/faq/how-do-i-add-jobs-to-cron-under-linux-or-unix-oses/
     * https://help.ubuntu.com/community/CronHowto
     */
    

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {         
        /**
         * Delete old records at every midnight
         */
        $schedule->command('weather:clean')->dailyAt('02:00');     
        
        /**
         * Update weather current data at every two hours  
         */
        $schedule->command('weather:current')->cron('0 */2 * * *');  
        
        /**
         * Update weather current data at every two hours  
         */
        $schedule->command('weather:daily')->cron('0 */2 * * *');
       
        /**
         * Update weather current data at every two hours  
         */
        $schedule->command('weather:hourly')->cron('0 */2 * * *');       
    }
}
