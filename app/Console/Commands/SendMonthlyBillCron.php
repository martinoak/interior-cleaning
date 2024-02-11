<?php

namespace App\Console\Commands;

use App\Mail\SendMonthlyBillMail;
use App\Models\Facades\DatabaseFacade;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlyBillCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monthly-bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to send bill on a monthly basis every 31st of the month';

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
        ;
        $file = fopen(storage_path('logs/cron.log'), 'a');
        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Monthly Bill started\n");

        $invoices = Invoice::whereMonth('date', date('m'))->get();

        $total = 0;
        foreach ($invoices as $invoice) {
            $invoice->type === 'N' ? $total -= $invoice->price : $total += $invoice->price;
        }

        Mail::to('stepan@cisteni-kondrac.cz')->send(new SendMonthlyBillMail($total));

        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Monthly Bill finished\n");
    }
}
