<?php

namespace App\Console\Commands;

use App\Mail\SendTodayScheduleMail;
use App\Models\Facades\DatabaseFacade;
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

    public function __construct(
        private readonly DatabaseFacade $facade
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $recipients = ['stepan@cisteni-kondrac.cz'];
        $file = fopen(storage_path('logs/cron.log'), 'a');
        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Today schedule started\n");

        $customers = $this->facade->getTodayCustomers();

        if(count($customers) === 0) {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] No customers for weekend schedule\n");
        } else {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] Customers today: " . count($customers) . "\n");

            foreach ($recipients as $recipient) {
                Mail::to($recipient)
                    ->bcc('martin.dub@dek-cz.com')
                    ->send(new SendTodayScheduleMail($customers));

                fwrite($file, date('Y-m-d H:i:s') . ' [CRON] Today schedule sent to ' . $recipient . "\n");
            }
        }
    }
}
