<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Services\GuzzleService;

class GetGoogleMapsReviewsCron extends Command
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
        private readonly GuzzleService $guzzleService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reviews = $this->guzzleService->getGoogleMapsReviews();

        $info = [];
        foreach ($reviews as $review) {
            $info = [
                'hash' => md5($review['author_name'] . $review['text']),
                'fullname' => $review['author_name'],
                'message' => $review['text'],
                'rating' => $review['rating'],
                'variant' => NULL,
                'isGoogle' => true
            ];

            $this->guzzleService->saveReview($info); /* TODO */
        }
    }
}
