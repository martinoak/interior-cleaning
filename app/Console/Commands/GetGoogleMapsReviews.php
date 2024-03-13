<?php

namespace App\Console\Commands;

use App\Models\Feedback;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use App\Domain\Services\GuzzleService;
use Symfony\Component\Console\Command\Command as CommandAlias;

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
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle(): int
    {
        $reviews = $this->guzzleService->getGoogleMapsReviews();

        foreach ($reviews as $review) {
            $info = [
                'hash' => md5($review['author_name'] . $review['text']),
                'name' => $review['author_name'],
                'message' => $review['text'],
                'rating' => $review['rating'],
                'fromGoogle' => true
            ];

            if (! Feedback::exists($info['hash'])) {
                Feedback::create($info);
            }
        }

        return CommandAlias::SUCCESS;
    }
}
