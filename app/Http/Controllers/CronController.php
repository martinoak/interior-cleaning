<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    public function today(): void
    {
        Artisan::call('app:today');
    }

    public function bill(): void
    {
        Artisan::call('app:monthly-bill');
    }

    public function invalidateVouchers(): void
    {
        Artisan::call('app:invalidate-vouchers');
    }

    public function carPark(): void
    {
        Artisan::call('app:car-park');
    }
}
