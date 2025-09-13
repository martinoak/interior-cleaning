<?php

namespace App\Enums;

enum InvoiceTypes: string
{
    case EARNING = 'T';
    case EXPENSE = 'V';
    case SALARY = 'M';
    case VOUCHER = 'P';
    case OTHER = 'O';

    public function getReadableFormat(): string
    {
        return match ($this) {
            self::EARNING => 'Tržba',
            self::EXPENSE => 'Výdaj',
            self::SALARY => 'Mzda',
            self::VOUCHER => 'Poukaz',
            default => 'Ostatní'
        };
    }

    public static function getHtmlSpan(string $type): string
    {
        return match ($type) {
            'T' => '<span class="badge-green">'.self::EARNING->getReadableFormat().'</span>',
            'V' => '<span class="badge-red">'.self::EXPENSE->getReadableFormat().'</span>',
            'M' => '<span class="badge-yellow">'.self::SALARY->getReadableFormat().'</span>',
            'P' => '<span class="badge-blue">'.self::VOUCHER->getReadableFormat().'</span>',
            default => '<span class="badge-gray">'.self::OTHER->getReadableFormat().'</span>',
        };
    }
}
