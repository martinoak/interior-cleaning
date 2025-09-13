<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class OniSystemService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => env('ONI_SYSTEM_SSL_VERIFY', false),
            'timeout' => env('ONI_SYSTEM_TIMEOUT', 30),
            'connect_timeout' => env('ONI_SYSTEM_CONNECT_TIMEOUT', 10),
        ]);
    }

    public static function getBaseUri(): string
    {
        return 'https://www.onisystem.net/inetgweb/ws/driveexp.jsp';
    }

    public static function getFormParams(array $range): array
    {
        return array_merge($range, [
            'IDOWN' => env('ONI_SYSTEM_IDOWN'),
            'WORK' => env('ONI_SYSTEM_WORK'),
            'USER' => env('ONI_SYSTEM_USER'),
            'PASSW' => env('ONI_SYSTEM_PASSW'),
        ]);
    }

    /**
     * Get list of vehicles from ONI system
     *
     * @throws GuzzleException
     */
    public function getVehicleList(): string
    {
        try {
            $response = $this->client->post(self::getBaseUri(), [
                RequestOptions::FORM_PARAMS => self::getFormParams(['ACT' => 'listobj']),
            ]);

            $data = $response->getBody()->getContents();

            Log::info('ONI System: Successfully fetched vehicle list', [
                'response_length' => strlen($data),
                'status_code' => $response->getStatusCode(),
            ]);

            return $data;
        } catch (GuzzleException $e) {
            Log::error('ONI System: Failed to fetch vehicle list', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            throw $e;
        }
    }

    /**
     * Parse the raw ONI system data into structured array
     */
    public function parseVehicleData(string $rawData): array
    {
        $lines = explode("\n", trim($rawData));
        $vehicles = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $fields = explode("\t", $line);

            // Based on the example data structure
            $vehicles[] = [
                'id' => $fields[0] ?? '',
                'name' => $fields[1] ?? '',
                'is_active' => $fields[2] ?? '',
                'spz' => $fields[3] ?? '',
                'year' => $fields[8] ?? '',
                'fuel_type' => $fields[25] ?? '',
                'vehicle_type' => $fields[28] ?? '',
                'color' => $fields[32] ?? '',
                'email_nocomm' => $fields[33] ?? '',
                'intern_code' => $fields[54] ?? '',
            ];
        }

        return $vehicles;
    }

    /**
     * Get parsed vehicle list
     *
     * @throws GuzzleException
     */
    public function getParsedVehicleList(): array
    {
        $rawData = $this->getVehicleList();

        return $this->parseVehicleData($rawData);
    }
}
