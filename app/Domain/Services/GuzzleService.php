<?php

namespace App\Domain\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

readonly class GuzzleService
{
    public function __construct(
        private Client $guzzleClient
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getGoogleMapsReviews(): array
    {
        $response = $this->guzzleClient->get('https://maps.googleapis.com/maps/api/place/details/json', [
            'query' => [
                'placeid' => 'ChIJ56G-hWSJDEcREctIevUbpDo',
                'key' => env('GOOGLE_MAPS_API_KEY'),
                'reviews_no_translations' => true,
                'fields' => 'review'
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['result']['reviews'];
    }
}
