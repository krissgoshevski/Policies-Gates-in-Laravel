<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class TaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for updating the tasks"s due_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ovde se pisuva logikata na ovaa komanda sto da pravi kade da odi koga ke se povika 
        // cron job za taskovite da gi pravi do denesnoto dato site sto imaat pominata data 

        Task::where('due_date', '<=', Carbon::now()) // ova znaci site sto se od prethodnoto dato da i stavime denesno dato
        ->update(['due_date' => Carbon::now()]); // update na denesnoto dato za site sto i pominal ovoj den 

        $this->info('Tasks for column due_date updated successfully with the current date.'); // 
    }
}
