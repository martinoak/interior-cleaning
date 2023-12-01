<?php

namespace App\Domain\Services;

use GuzzleHttp\Client;

class GuzzleService
{
    public function __construct(
        private readonly Client $guzzleClient
    ) {
    }

    public function getGoogleMapsReviews(): array
    {
        $response = $this->guzzleClient->get('https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ56G-hWSJDEcREctIevUbpDo&key=AIzaSyB_yimuufG5LKyQhrH7GB2SUxCwUIxZEiw&reviews_no_translations=true&fields=review', [
            'query' => [
                'placeid' => 'ChIJ56G-hWSJDEcREctIevUbpDo',
                'key' => 'AIzaSyB_yimuufG5LKyQhrH7GB2SUxCwUIxZEiw',
                'reviews_no_translations' => true,
                'fields' => 'review'
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
