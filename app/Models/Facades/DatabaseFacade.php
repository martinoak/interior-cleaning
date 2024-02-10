<?php

namespace App\Models\Facades;

use App\Enums\CleaningTypes;
use App\Models\Customer;
use App\Models\Feedback;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DatabaseFacade
{
    public function getInvoices(): array
    {
        return Invoice::orderBy('date', 'desc')->get()->toArray();
    }

    public function getThisYearInvoices(): array
    {
        return Invoice::whereYear('date', date('Y'))->get()->toArray();
    }

    public function getThisMonthInvoices(): array
    {
        return Invoice::whereMonth('date', date('m'))->get()->toArray();
    }

    public function getFirstFutureCustomer(): string
    {
        $customer = Customer::where('archived', 0)
            ->where('term', '>=', date('Y-m-d'))
            ->orderBy('term')
            ->first();

        return $customer ? date('j.n.', strtotime($customer->term)) : 'Žádný';
    }

    public function getVouchers(?array $where = []): array
    {
        if ($where) {
            return DB::table('vouchers')->where($where)->get()->toArray();
        } else {
            return DB::table('vouchers')->get()->toArray();
        }
    }

    public function getVoucherByHash(string $hash): ?object
    {
        return DB::table('vouchers')->where('hash', $hash)->first();
    }

    public function getNotAcceptedVouchers(): array
    {
        return DB::table('vouchers')->where('accepted', 0)->orderBy('date', 'desc')->get()->toArray();
    }

    public function saveVoucher(string $hash, string $dateOffset, int $price = 0): void
    {
        DB::table('vouchers')->insert([
            'hash' => $hash,
            'date' => \DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->modify($dateOffset)->format('Y-m-d'),
            'price' => $price,
        ]);
    }

    public function useVoucher(string $hash): void
    {
        DB::table('vouchers')->where('hash', $hash)->update(['accepted' => 1]);
    }
}
