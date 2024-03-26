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
            'T' => '<span class="bg-green-100 text-green-800 dark:bg-green-800 dark:text-white rounded-full px-3 py-1 text-xs font-semibold">'.self::EARNING->getReadableFormat().'</span>',
            'V' => '<span class="bg-red-100 text-red-800 dark:bg-red-800 dark:text-white rounded-full px-3 py-1 text-xs font-semibold">'.self::EXPENSE->getReadableFormat().'</span>',
            'M' => '<span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 rounded-full px-3 py-1 text-xs font-semibold">'.self::SALARY->getReadableFormat().'</span>',
            'P' => '<span class="bg-[#3056d3] text-white dark:bg-[#3056d3] dark:text-white rounded-full px-3 py-1 text-xs font-semibold">'.self::VOUCHER->getReadableFormat().'</span>',
            default => '<span class="bg-gray-300 text-gray-800 dark:bg-gray-600 dark:text-gray-100 rounded-full px-3 py-1 text-xs font-semibold">'.self::OTHER->getReadableFormat().'</span>',
        };
    }
}
