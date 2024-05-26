<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send'; // name of the command 


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for sending emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::send('email-send.email-send', [], function ($message) {
            $message->to('kristijan.gosevski@neotel.mk')
            ->subject('Test Schedule job');
        });
    }
}
