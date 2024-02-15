<?php

namespace App\Models\Facades;

use App\Models\Customer;
use App\Models\Voucher;

class DatabaseFacade
{
    public function getFirstFutureCustomer(): string
    {
        $customer = Customer::where('archived', 0)
            ->where('term', '>=', date('Y-m-d'))
            ->orderBy('term')
            ->first();

        return $customer ? date('j.n.', strtotime($customer->term)) : 'Žádný';
    }

    public function saveVoucher(string $hash, string $dateOffset, int $price = 0): void
    {
        Voucher::create([
            'hash' => $hash,
            'date' => \DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->modify($dateOffset)->format('Y-m-d'),
            'price' => $price,
        ]);
    }
}
