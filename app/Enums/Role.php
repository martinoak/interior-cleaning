<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case CLEANING = 'cleaning';
    case CAR_PARK = 'car-park';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getName(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::CLEANING => 'Čištění',
            self::CAR_PARK => 'Auta',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ADMIN => 'fa-solid fa-screwdriver-wrench',
            self::CLEANING => 'fa-solid fa-soap',
            self::CAR_PARK => 'fa-solid fa-car-side',
        };
    }
}
