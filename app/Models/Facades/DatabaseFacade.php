<?php

namespace App\Models\Facades;

use App\Models\Customer;
use App\Models\Voucher;
use DateTime;

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
}
