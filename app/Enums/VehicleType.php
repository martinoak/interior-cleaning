<?php

namespace App\Enums;

enum VehicleType: string
{
    case CAR = 'car';
    case TRUCK = 'truck';
    case WORK = 'work';

    public function getName(): string
    {
        return match ($this) {
            self::CAR => 'Osobní',
            self::TRUCK => 'Nákladní',
            self::WORK => 'Pracovní',
        };
    }

    public static function getIcon(string $type): string
    {
        return match ($type) {
            self::CAR->value => 'fa-solid fa-car-side',
            self::TRUCK->value => 'fa-solid fa-truck-moving',
            self::WORK->value => 'fa-solid fa-tractor',
        };
    }
}
