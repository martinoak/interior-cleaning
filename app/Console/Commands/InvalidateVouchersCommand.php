<?php

namespace App\Console\Commands;

use App\Models\Voucher;
use Illuminate\Console\Command;

class InvalidateVouchersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:invalidate-vouchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invalidate all vouchers past due';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $file = fopen(storage_path('logs/cron.log'), 'a');
        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Invalidate vouchers started\n");

        $vouchers = Voucher::all();
        $counter = 0;
        foreach ($vouchers as $voucher) {

            if (strtotime($voucher->date) < time()) {
                Voucher::where('hash', $voucher->hash)->update(['expired' => 1]);
            }
        }

        fwrite($file, date('Y-m-d H:i:s') . " [CRON] Invalidated $counter vouchers\n");
    }
}
