<?php

namespace App\Console\Commands;

use App\Enums\CarParkDates;
use App\Mail\ExpiringDatesMail;
use App\Mail\NewSeasonMail;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class CarParkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:car-park';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron, který kontroluje vozový park';

    private Carbon $summerSeasonStart;

    private Carbon $winterSeasonStart;

    private Collection $expiring;

    private array $to = ['autohoulik@seznam.cz'];

    public function __construct()
    {
        $this->expiring = collect(['stk' => collect(), 'insurance' => collect(), 'oilChange' => collect(), 'tachograph' => collect()]);

        $this->summerSeasonStart = Carbon::createFromDate(now()->year, 4, 1);
        $this->winterSeasonStart = Carbon::createFromDate(now()->year, 11, 1);

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $file = fopen(storage_path('logs/cron.log'), 'a');

        $this->getExpirations();

        $this->summerSeasonStart->isToday() && $this->announceNewSeason('summer');
        $this->winterSeasonStart->isToday() && $this->announceNewSeason('winter');

        fwrite($file, date('Y-m-d H:i:s').' [CRON] Vozový park byl zkontrolován.'.PHP_EOL);
        echo "[CRON] Vozový park byl zkontrolován.\n";
    }

    private function getExpirations(): void
    {
        $sendEmail = false;

        foreach (Vehicle::all() as $vehicle) {
            if ($vehicle->stk && abs($vehicle->stk->diffInDays(now())) <= CarParkDates::getFirstWarning('stk')) {
                $this->expiring['stk']->push($vehicle);
                $sendEmail = true;
            }

            if ($vehicle->insurance && abs($vehicle->insurance->diffInDays(now())) <= CarParkDates::getFirstWarning('insurance')) {
                $this->expiring['insurance']->push($vehicle);
                $sendEmail = true;
            }

            if ($vehicle->oilChange && abs($vehicle->oilChange->diffInDays(now())) <= CarParkDates::getFirstWarning('oilChange')) {
                $this->expiring['oilChange']->push($vehicle);
                $sendEmail = true;
            }

            if ($vehicle->tachograph && abs($vehicle->tachograph->diffInDays(now())) <= CarParkDates::getFirstWarning('tachograph')) {
                $this->expiring['tachograph']->push($vehicle);
                $sendEmail = true;
            }
        }

        $sendEmail && Mail::to($this->to)->send(new ExpiringDatesMail($this->expiring));
    }

    private function announceNewSeason(string $season): void
    {
        Mail::to($this->to)->send(new NewSeasonMail($season));
    }
}
