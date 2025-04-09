<?php

namespace App\Enums;

enum CarParkDates: string
{
    case STK = 'stk';
    case INSURANCE = 'insurance';
    case OIL_CHANGE = 'oilChange';
    case TACHOGRAPH = 'tachograph';

    public static function getTitle(string $key): string
    {
        return match ($key) {
            self::STK->value => 'STK',
            self::INSURANCE->value => 'Povinné ručení',
            self::OIL_CHANGE->value => 'Výměna oleje',
            self::TACHOGRAPH->value => 'Tachograf',
        };
    }
}
