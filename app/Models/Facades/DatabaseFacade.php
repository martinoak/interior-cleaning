<?php

namespace App\Models\Facades;

use App\Enums\CleaningTypes;
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

    public function saveFeedback(array $data, ?string $variant = null): void
    {
        $isDuplicity = $this->getFeedbackByHash($data['hash']);

        if (!$isDuplicity) {
            DB::table('feedbacks')->insert([
                'hash' => $data['hash'],
                'fullname' => $data['fullname'],
                'message' => $data['message'],
                'rating' => $data['stars'],
                'variant' => $variant,
                'isGoogle' => $data['isGoogle'] ?? false,
            ]);
        }
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

    public function saveInvoice(array $data): void
    {
        DB::table('invoices')->insert([
            'type' => $data['type'],
            'date' => $data['date'],
            'name' => $data['name'],
            'price' => $data['price'],
            'worker' => $data['worker'],
        ]);
    }

    public function getCustomers(?array $where = []): array
    {
        if ($where) {
            return DB::table('customers')->where($where)->orderBy('id', 'desc')->get()->toArray();
        } else {
            return DB::table('customers')->orderBy('id', 'desc')->get()->toArray();
        }
    }

    public function getCustomerById(int $id): array
    {
        return DB::table('customers')->where('id', $id)->first()->toArray();
    }

    public function getThisWeekendCustomers(): array
    {
        return DB::table('customers')
            ->whereBetween('hasTerm', [date('Y-m-d'), date('Y-m-d', strtotime('+1 day'))])
            ->get()
            ->sortBy('hasTerm')
            ->groupBy('hasTerm')
            ->toArray();
    }

    public function saveCustomer(array $data): void
    {
        DB::table('customers')->insert([
            'fullname' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['phone'],
            'message' => $data['message'],
            'variant' => $data['variant'],
        ]);
    }

    public function getFirstFutureCustomer(): string
    {
        $customer = DB::table('customers')->where('hasTerm', '>=', date('Y-m-d'))->orderBy('hasTerm')->first();
        if ($customer) {
            $term = \DateTime::createFromFormat('Y-m-d', $customer->hasTerm);
            return $term->format('j.n.');
        } else {
            return 'Žádný';
        }

    }

    public function archiveCustomer(int $id): void
    {
        DB::table('customers')->where('id', $id)->update(['isArchived' => 1]);
    }

    public function getNotArchivedCustomers(): array
    {
        return DB::table('customers')->where('isArchived', 0)->get()->toArray();
    }

    public function getTotalVariants(CleaningTypes $type): int
    {
        return DB::table('customers')->where('variant', $type)->count();
    }

    public function addToCalendar(array $data): void
    {
        DB::table('calendar')->insert([
            'name' => $data['name'],
            'date' => $data['date'],
            'variant' => $data['variant'],
            'description' => $data['message'],
            'isDone' => 0,
        ]);
    }

    public function assignTermToCustomer(string $name, string $date): void
    {
        DB::table('customers')->where('fullname', $name)->update(['hasTerm' => $date]);
    }

    public function getVouchers(?array $where = []): array
    {
        if ($where) {
            return DB::table('vouchers')->where($where)->get()->toArray();
        } else {
            return DB::table('vouchers')->get()->toArray();
        }
    }

    public function getVoucherByHash(string $hash): bool
    {
        return DB::table('vouchers')->where('hash', $hash)->exists();
    }

    public function getNotAcceptedVouchers(): array
    {
        return DB::table('vouchers')->where('isAccepted', 0)->orderBy('date', 'desc')->get()->toArray();
    }

    public function saveVoucher(string $hash, string $dateOffset, int $price = 0): void
    {
        DB::table('vouchers')->insert([
            'hash' => $hash,
            'date' => date('d-m-Y', strtotime($dateOffset)),
            'price' => $price,
        ]);
    }

    public function useVoucher(string $hash): void
    {
        DB::table('vouchers')->where('hash', $hash)->update(['isAccepted' => 1]);
    }
}
