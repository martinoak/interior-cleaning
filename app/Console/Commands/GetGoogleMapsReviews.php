<?php

namespace App\Console\Commands;

use App\Models\Facades\DatabaseFacade;
use Illuminate\Console\Command;
use App\Domain\Services\GuzzleService;

class GetGoogleMapsReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Google Maps Reviews with API';

    public function __construct(
        private readonly GuzzleService  $guzzleService,
        private readonly DatabaseFacade $facade,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $reviews = $this->guzzleService->getGoogleMapsReviews();

        foreach ($reviews as $review) {
            $info = [
                'hash' => md5($review['author_name'] . $review['text']),
                'fullname' => $review['author_name'],
                'message' => $review['text'],
                'stars' => $review['rating'],
                'isGoogle' => true
            ];

            $this->facade->saveFeedback($info);
        }

        return Command::SUCCESS;
    }
}
