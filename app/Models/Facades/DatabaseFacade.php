<?php

namespace App\Models\Facades;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Voucher;
use Illuminate\Support\Collection;

class DatabaseFacade
{
    public function getInvoices(): Collection
    {
        return Invoice::orderBy('date', 'desc')->get();
    }

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
