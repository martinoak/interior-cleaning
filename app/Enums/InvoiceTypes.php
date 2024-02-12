<?php

namespace App\Enums;

enum InvoiceTypes: string
{
    case EARNING = 'Tržba';
    case EXPENSE = 'Výdaj';
    case SALARY = 'Mzda';
    case VOUCHER = 'Poukaz';
    case OTHER = 'Ostatní';

    public static function getName(string $type): InvoiceTypes
    {
        return match ($type) {
            'T' => self::EARNING,
            'N' => self::EXPENSE,
            'M' => self::SALARY,
            'P' => self::VOUCHER,
            'O' => self::OTHER,
        };
    }
}
