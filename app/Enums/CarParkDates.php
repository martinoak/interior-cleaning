<?php

namespace App\Enums;

enum CarParkDates: string
{
    case STK = 'stk';
    case INSURANCE = 'insurance';
    case OIL_CHANGE = 'oilChange';
    case TACHOGRAPH = 'tachograph';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getTitle(): string
    {
        return match ($this) {
            self::STK => 'STK',
            self::INSURANCE => 'Povinné ručení',
            self::OIL_CHANGE => 'Výměna oleje',
            self::TACHOGRAPH => 'Tachograf',
        };
    }

    public static function getFirstWarning(string $key): int
    {
        return match ($key) {
            self::STK->value => 30,
            self::INSURANCE->value => 90,
            self::OIL_CHANGE->value => 30,
            self::TACHOGRAPH->value => 14,
        };
    }

    public static function getSecondWarning(string $key): int
    {
        return match ($key) {
            self::STK->value => 7,
            self::INSURANCE->value => 60,
            self::OIL_CHANGE->value => 7,
            self::TACHOGRAPH->value => 2,
        };
    }
}
