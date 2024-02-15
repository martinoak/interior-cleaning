<?php

namespace App\Console\Commands;

use App\Mail\SendTodayScheduleMail;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDayScheduleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send today schedule.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $recipients = ['stepan@cisteni-kondrac.cz'];
        $file = fopen(storage_path('logs/cron.log'), 'a');
        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Today schedule started\n");

        $customers = Customer::where('term', date('Y-m-d'))->get();

        if(count($customers) === 0) {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] No customers for weekend schedule\n");

            echo "No customers for weekend schedule\n";
        } else {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] Customers today: " . count($customers) . "\n");

            foreach ($recipients as $recipient) {
                Mail::to($recipient)->send(new SendTodayScheduleMail($customers));

                fwrite($file, date('Y-m-d H:i:s') . ' [CRON] Today schedule sent to ' . $recipient . "\n");
            }

            echo "Today schedule sent\n";
        }
    }
}
