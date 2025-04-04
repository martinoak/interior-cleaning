<?php

namespace App\Console\Commands;

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
    protected $description = 'Cron, který každý den kontroluje vozový park';

    private int $firstWarning = 30;

    private int $secondWarning = 7;

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
        foreach (Vehicle::all() as $vehicle) {
            if ($vehicle->stk?->diffInDays(now()) <= $this->firstWarning) {
                $this->expiring['stk']->push($vehicle);
            }

            if ($vehicle->insurance?->diffInDays(now()) <= $this->firstWarning) {
                $this->expiring['insurance']->push($vehicle);
            }

            if ($vehicle->oilChange?->diffInDays(now()) <= $this->firstWarning) {
                $this->expiring['oilChange']->push($vehicle);
            }

            if ($vehicle->tachograph?->diffInDays(now()) <= $this->firstWarning) {
                $this->expiring['tachograph']->push($vehicle);
            }
        }

        // TODO: Send email with expiring vehicles
    }

    private function announceNewSeason(string $season): void
    {
        Mail::to($this->to)->send(new NewSeasonMail($season));
    }
}
