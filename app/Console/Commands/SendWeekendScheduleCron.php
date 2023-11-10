<?php

namespace App\Console\Commands;

use App\Mail\SendWeekendScheduleMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendWeekendScheduleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weekend-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekend Schedule on Saturday.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $recipient = 'stepan@cisteni-kondrac.cz';
        $file = fopen(storage_path('logs/cron.log'), 'a');
        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Weekend schedule started\n");

        $customers = DB::table('customers')
            ->whereBetween('hasTerm', [date('Y-m-d'), date('Y-m-d', strtotime('+1 day'))])
            ->get()
            ->sortBy('hasTerm')
            ->groupBy('hasTerm')
            ->toArray();

        if(count($customers) === 0) {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] No customers for weekend schedule\n");
        } else {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] Weekend schedule customers: " . count($customers) . "\n");
            Mail::to($recipient)->send(new SendWeekendScheduleMail($customers));
            fwrite($file, date('Y-m-d H:i:s') . ' [CRON] Weekend schedule sent to ' . $recipient . "\n");
        }
    }
}
