<?php

namespace App\Enums;

enum VehicleType: string
{
    case CAR = 'car';
    case TRUCK = 'truck';

    public static function getIcon(string $type): string
    {
        return match ($type) {
            self::CAR->value => 'fa-solid fa-car-side',
            self::TRUCK->value => 'fa-solid fa-truck-moving',
        };
    }
}
