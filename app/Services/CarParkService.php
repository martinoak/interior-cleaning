<?php

namespace App\Services;

class CarParkService
{
    public static function getTyreSeason(int $year): int
    {
        return date('Y') - $year + (date('n') > 4 || (date('n') == 4 && date('j') > 1) ? 1 : 0);
    }

}
