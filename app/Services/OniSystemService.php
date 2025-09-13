<?php

namespace App\Services;

class OniSystemService
{
    public static function getBaseUri(): string
    {
        return 'https://www.onisystem.net/inetgweb/ws/driveexp.jsp';
    }

    public static function getFormParams(): array
    {
        return [
            'IDOWN' => env('ONI_SYSTEM_IDOWN'),
            'WORK' => env('ONI_SYSTEM_WORK'),
            'USER' => env('ONI_SYSTEM_USER'),
            'PASSW' => env('ONI_SYSTEM_PASSW')
        ];
    }
}
