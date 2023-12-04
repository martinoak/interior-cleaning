<?php

namespace App\Console\Commands;

use App\Mail\SendWeekendScheduleMail;
use App\Models\Facades\DatabaseFacade;
use Illuminate\Console\Command;
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
        $recipient = 'stepan@cisteni-kondrac.cz';
        $file = fopen(storage_path('logs/cron.log'), 'a');
        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Weekend schedule started\n");

        $customers = $this->facade->getThisWeekendCustomers();

        if(count($customers) === 0) {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] No customers for weekend schedule\n");
        } else {
            fwrite($file, date('Y-m-d H:i:s') . " [CRON] Weekend schedule customers: " . count($customers) . "\n");
            Mail::to($recipient)
                ->bcc('martin.dub@dek-cz.com')
                ->send(new SendWeekendScheduleMail($customers));

            fwrite($file, date('Y-m-d H:i:s') . ' [CRON] Weekend schedule sent to ' . $recipient . "\n");
        }
    }
}
