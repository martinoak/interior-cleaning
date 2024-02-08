<?php

namespace App\Models\Facades;

use App\Enums\CleaningTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatabaseFacade
{
    public function getFeedbacks(): array
    {
        return DB::table('feedbacks')->get()->toArray();
    }

    public function getFeedbackByHash(string $hash): bool
    {
        return DB::table('feedbacks')->where('hash', $hash)->exists();
    }

    public function setFeedbackSent(int $id): int
    {
        return DB::table('customers')->where('id', $id)->update(['feedbackSent' => 1]);
    }

    public function saveFeedback(array $data): void
    {
        $isDuplicity = $this->getFeedbackByHash($data['hash']);

        if (!$isDuplicity) {
            DB::table('feedbacks')->insert([
                'hash' => $data['hash'],
                'name' => $data['name'],
                'message' => $data['message'],
                'rating' => $data['stars'],
                'fromGoogle' => $data['fromGoogle'] ?? false,
            ]);
        }
    }

    public function linkCustomerToFeedback(int $customerId, string $feedbackHash): void
    {
        DB::table('customers')->where('id', $customerId)->update(['feedback_hash' => $feedbackHash]);
    }

    public function setVariant(int $id, string $variant): int
    {
        return DB::table('customers')->where('id', $id)->update(['variant' => $variant]);
    }

    public function getInvoices(): array
    {
        return DB::table('invoices')->orderBy('date', 'desc')->get()->toArray();
    }

    public function getInvoiceById(int $id): object
    {
        return DB::table('invoices')->where('id', $id)->first();
    }

    public function getThisYearInvoices(): array
    {
        return DB::table('invoices')->whereYear('date', date('Y'))->get()->toArray();
    }

    public function getThisMonthInvoices(): array
    {
        return DB::table('invoices')->whereMonth('date', date('m'))->get()->toArray();
    }

    public function saveInvoice(int $customerId): string|false
    {
        $customer = $this->getCustomerById($customerId);

        DB::table('invoices')->insert([
            'type' => 'T',
            'date' => $customer->term,
            'name' => $customer->name,
            'price' => CleaningTypes::from($customer->variant)->getRawPrice(),
            'worker' => 'S',
        ]);

        return DB::getPdo()->lastInsertId();
    }

    public function linkCustomerToInvoice(int $customerId, int $invoiceId): void
    {
        DB::table('customers')->where('id', $customerId)->update(['invoice_id' => $invoiceId]);
    }

    public function getCustomers(?array $where = []): array
    {
        if ($where) {
            return DB::table('customers')->where($where)->orderBy('id', 'desc')->get()->toArray();
        } else {
            return DB::table('customers')->orderBy('id', 'desc')->get()->toArray();
        }
    }

    public function getCustomerById(int $id): object
    {
        return DB::table('customers')->where('id', $id)->first();
    }

    public function getTodayCustomers(): array
    {
        return DB::table('customers')
            ->where('term', date('Y-m-d'))
            ->get()
            ->toArray();
    }

    public function saveCustomer(array $data): void
    {
        DB::table('customers')->insert([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'telephone' => $data['telephone'],
            'message' => $data['message'],
            'variant' => $data['variant'],
            'term' => $data['date'] ?? null
        ]);
    }

    public function updateCustomer(array $data): void
    {
        $customer = $this->getCustomerById($data['id']);

        DB::table('customers')->where('id', $data['id'])->update([
            'name' => $data['name'] ?? $customer->name,
            'email' => $data['email'] ?? $customer->email,
            'telephone' => $data['telephone'] ?? $customer->telephone,
            'variant' => $data['variant'] ?? $customer->variant,
            'message' => $data['message'] ?? $customer->message,
            'term' => $data['date'] ?? $customer->term,
        ]);
    }

    public function getFirstFutureCustomer(): string
    {
        $customer = DB::table('customers')
            ->where('archived', 0)
            ->where('term', '>=', date('Y-m-d'))
            ->orderBy('term')
            ->first();

        return $customer ? date('j.n.', strtotime($customer->term)) : 'Žádný';
    }

    public function archiveCustomer(int $id): void
    {
        DB::table('customers')->where('id', $id)->update(['archived' => 1]);
    }

    public function deleteCustomer(int $id): void
    {
        DB::table('customers')->where('id', $id)->delete();
    }

    public function getNotArchivedCustomers(): array
    {
        return DB::table('customers')->where('archived', 0)->get()->toArray();
    }

    public function getTotalVariants(CleaningTypes $type): int
    {
        return DB::table('customers')->where('variant', $type)->count();
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
