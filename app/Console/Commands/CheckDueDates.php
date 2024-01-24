<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Illuminate\Console\Command;

class CheckDueDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-due-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check due dates and send emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payments = Payment::where('latest', true)->get();
        if ($payments) {
            foreach ($payments as $key => $payment) {
                $recipient = $payment->company->subscriber->email;
                
            }

        }

    }
}
