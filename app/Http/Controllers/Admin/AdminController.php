<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CleaningTypes;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Feedback;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @throws Exception
     */
    public function dashboard(): View
    {
        if (!file_exists(storage_path('logs/cron.log'))) {
            file_put_contents(storage_path('logs/cron.log'), '');
        }

        $invoices = Invoice::all();
        $earnings = [];
        $total = 0;

        foreach ($invoices as $i) {
            $year = date('Y', strtotime($i->date));
            $earnings[$year] = ['01' => 0, '02' => 0, '03' => 0, '04' => 0, '05' => 0, '06' => 0, '07' => 0, '08' => 0, '09' => 0, '10' => 0, '11' => 0, '12' => 0];
        }

        foreach ($invoices as $i) {
            $year = date('Y', strtotime($i->date));
            if ($i->type === 'V' || $i->type === 'M') {
                $total -= $i->price;
                $earnings[$year][date('m', strtotime($i->date))] -= $i->price;
            } else {
                $total += $i->price;
                $earnings[$year][date('m', strtotime($i->date))] += $i->price;
            }
        }

        $first = Customer::where('archived', 0)->where('term', '>=', date('Y-m-d'))->orderBy('term')->first();
        $calendar = $first ? date('j.n.', strtotime($first->term)) : '-';

        $annual = 0;
        foreach (Invoice::whereYear('date', date('Y'))->get() as $a) {
            if ($a->type === 'N') {
                $annual -= $a->price;
            } else {
                $annual += $a->price;
            }
        }

        $month = 0;
        foreach (Invoice::whereMonth('date', date('m'))->get() as $m) {
            if ($m->type === 'N') {
                $month -= $m->price;
            } else {
                $month += $m->price;
            }
        }

        return view('admin.dashboard', [
            'customers' => Customer::where('archived', 0)->get(),
            'calendar' => $calendar,
            'annual' => $annual,
            'month' => $month,
            'variants' => [
                CleaningTypes::START->value => Customer::where('variant', CleaningTypes::START)->count(),
                CleaningTypes::MIDDLE->value => Customer::where('variant', CleaningTypes::MIDDLE)->count(),
                CleaningTypes::DELUXE->value => Customer::where('variant', CleaningTypes::DELUXE)->count(),
            ],
            'earnings' => $earnings,
            'total' => $total,
        ]);
    }

    public function showFeedback(): View
    {
        return view('admin.feedbacks', [
            'feedbacks' => Feedback::all(),
        ]);
    }

    public function refreshFeedbacks(): RedirectResponse
    {
        Artisan::call('app:get-reviews');

        return back()->with('success', 'Recenze z Google Map importovány!');
    }

    public function showDevelopment(): View
    {
        abort_if(Gate::denies('admin'), 403);

        return view('admin.development');
    }

    public function showErrorLog(string $type): View
    {
        abort_if(Gate::denies('admin'), 403);

        $log = file_get_contents(storage_path('logs/'.$type.'.log'));

        return view('admin.errorlog', [
            'log' => $log,
        ]);
    }
}
