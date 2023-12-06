<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    public function weekend(): void
    {
        Artisan::call('app:weekend-schedule');
    }

    public function bill(): void
    {
        Artisan::call('app:monthly-bill');
    }
}
