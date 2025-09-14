<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
     * Get parsed vehicle list
     *
     * @throws GuzzleException
     */
    public function getParsedVehicleList(): array
    {
        $rawData = $this->getVehicleList();

        return $this->parseVehicleData($rawData);
    }

    public function getRideHistory(string $id, string $timeFrom = '2025-09-01T00:00:00', string $timeTo = '2025-09-10T23:59:59'): string
    {
        $params = self::getFormParams([
            'ACT' => 'drives2',
            'IDOBJ' => $id,
            'TIMEFROM' => $timeFrom,
            'TIMETO' => $timeTo,
        ]);

        $response = $this->client->get(self::getBaseUri(), [
            'query' => $params,
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Get list of vehicles from ONI system
     *
     * @throws GuzzleException
     */
    private function getVehicleList(): string
    {
        $response = $this->client->get(self::getBaseUri(), [
            'query' => self::getFormParams(['ACT' => 'listobj']),
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Parse the raw ONI system data into structured array
     */
    private function parseVehicleData(string $rawData): array
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
                'IDOBJ' => $fields[0] ?? '',
                'NAZEV' => $fields[1] ?? '',
                'AKTIVNÍ' => $fields[2] ?? '',
                'SPZ' => $fields[3] ?? '',
                'VYR' => $fields[8] ?? '',
                'IDSRC' => $fields[25] ?? '',
                'DRUH' => $fields[28] ?? '',
                'COLOR' => $fields[32] ?? '',
                'EMAIL_NOCOMM' => $fields[33] ?? '',
            ];
        }

        return $vehicles;
    }

    /**
     * Parse the raw ONI ride history data into structured array
     */
    private function parseRideHistoryData(string $rawData): array
    {
        $lines = explode("\n", trim($rawData));
        $rides = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            $fields = explode("\t", $line);

            // Based on the example ride history data structure
            $rides[] = [
                'IDDRIVE' => $fields[0] ?? '',
                'STARTTIME' => $fields[1] ?? '',
                'STARTGPSLO' => $fields[2] ?? '',
                'STARTGPSLA' => $fields[3] ?? '',
                'STOPTIME' => $fields[5] ?? '',
                'STOPGPSLO' => $fields[6] ?? '',
                'STOPGPSLA' => $fields[7] ?? '',
                'DRIVETYPE' => $fields[10] ?? '',
                'DRIVEDIST' => $fields[11] ?? '',
                'STARTOBEC' => $fields[12] ?? '',
                'STOPOBEC' => $fields[13] ?? '',
                'STARTSTAT' => $fields[16] ?? '',
                'STARTSTATN' => $fields[17] ?? '',
                'STARTCISPOP' => $fields[20] ?? '',
                'STARTCISOR' => $fields[21] ?? '',
                'STOPSTAT' => $fields[22] ?? '',
                'STOPSTATN' => $fields[23] ?? '',
                'STOPCISPOP' => $fields[26] ?? '',
                'STOPCISOR' => $fields[27] ?? '',
                'VEMAX' => $fields[28] ?? '',
                'VEAVG' => $fields[29] ?? '',
                'TIMEDIFF' => $fields[30] ?? '',
                'MOTOHOD' => $fields[39] ?? '',
            ];
        }

        return $rides;
    }

    /**
     * Get parsed ride history
     *
     * @throws GuzzleException
     */
    public function getParsedRideHistory(string $id, string $timeFrom = '2025-09-01T00:00:00', string $timeTo = '2025-09-10T23:59:59'): array
    {
        $rawData = $this->getRideHistory($id, $timeFrom, $timeTo);

        return $this->parseRideHistoryData($rawData);
    }
}
