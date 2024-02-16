<?php

namespace App\Enums;

enum InvoiceTypes: string
{
    case EARNING = 'Tržba';
    case EXPENSE = 'Výdaj';
    case SALARY = 'Mzda';
    case VOUCHER = 'Poukaz';
    case OTHER = 'Ostatní';

    public static function getHtmlSpan(string $type): string
    {
        return match ($type) {
            'T' => '<span class="bg-green-100 text-green-800 dark:bg-green-800 dark:text-white rounded-full px-3 py-1 text-xs font-semibold">'.self::EARNING->value.'</span>',
            'V' => '<span class="bg-red-100 text-red-800 dark:bg-red-800 dark:text-white rounded-full px-3 py-1 text-xs font-semibold">'.self::EXPENSE->value.'</span>',
            'M' => '<span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 rounded-full px-3 py-1 text-xs font-semibold">'.self::SALARY->value.'</span>',
            'P' => '<span class="bg-[#3056d3] text-white dark:bg-[#3056d3] dark:text-white rounded-full px-3 py-1 text-xs font-semibold">'.self::VOUCHER->value.'</span>',
            default => '<span class="bg-gray-300 text-gray-800 dark:bg-gray-600 dark:text-gray-100 rounded-full px-3 py-1 text-xs font-semibold">'.self::OTHER->value.'</span>',
        };
    }
}
