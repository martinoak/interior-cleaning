<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use DateTime;
use Exception;
use GdImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    public function archiveMember($id): RedirectResponse
    {
        DB::table('customers')->where('id', $id)->update(['isArchived' => 1]);

        return back()->with('success', 'Zákazník byl archivován');
    }

    /**
     * @throws Exception
     */
    public function showDashboard(): View
    {
        if (!file_exists(storage_path('logs/cron.log'))) {
            file_put_contents(storage_path('logs/cron.log'), '');
        }

        $invoices = DB::table('invoices')->get()->toArray();
        $earnings = [];

        foreach ($invoices as $i) {
            $year = date('Y', strtotime($i->date));
            $earnings[$year] = [
                '01' => 0,
                '02' => 0,
                '03' => 0,
                '04' => 0,
                '05' => 0,
                '06' => 0,
                '07' => 0,
                '08' => 0,
                '09' => 0,
                '10' => 0,
                '11' => 0,
                '12' => 0,
                ];
        }

        foreach ($invoices as $i) {
            $year = date('Y', strtotime($i->date));
            $month = date('m', strtotime($i->date));
            if ($i->type === 'N') {
                $earnings[$year][date('m', strtotime($i->date))] -= $i->price;
            } else {
                $earnings[$year][date('m', strtotime($i->date))] += $i->price;
            }
        }

        return view('admin.admin', [
            'customers' => DB::table('customers')->where('isArchived', 0)->get(),
            'calendar' => (new DateTime(DB::table('calendar')->where('isDone', 0)->orderBy('date')->first()->date))->format('j.n.'),
            'annualEarnings' => DB::table('invoices')->whereYear('date', date('Y'))->sum('price'),
            'monthlyEarnings' => DB::table('invoices')->whereMonth('date', date('m'))->sum('price'),
            'variants' => [
                CleaningTypes::START->value => DB::table('customers')->where('variant', CleaningTypes::START)->count(),
                CleaningTypes::MIDDLE->value => DB::table('customers')->where('variant', CleaningTypes::MIDDLE)->count(),
                CleaningTypes::DELUXE->value => DB::table('customers')->where('variant', CleaningTypes::DELUXE)->count()
            ],
            'earnings' => $earnings,
        ]);
    }

    public function showCalendar(): View
    {
        return view('admin.calendar', [
            'orders' => DB::table('calendar')->orderBy('date')->get()->where('isDone', 0),
            'fOrders' => DB::table('calendar')->orderBy('date', 'desc')->get()->where('isDone', 1),
        ]);
    }

    public function showFeedback(): View
    {
        return view('admin.feedbacks', [
            'feedbacks' => DB::table('feedback')->get(),
        ]);
    }

    public function showInvoices(): View
    {
        return view('admin.invoices', [
            'invoices' => DB::table('invoices')->orderBy('date', 'desc')->get(),
        ]);
    }

    public function showCustomers(): View
    {
        return view('admin.customers', [
            'customers' => DB::table('customers')->where('isArchived', 0)->orderBy('id', 'desc')->get(),
            'archived' => DB::table('customers')->where('isArchived', 1)->orderBy('id', 'desc')->get(),
        ]);
    }

    public function showVouchers(): View
    {
        return view('admin.vouchers', [
            'vouchers' => DB::table('vouchers')->where('isAccepted', 0)->orderBy('date', 'desc')->get(),
            'hex' => 'x'.strtoupper(substr(md5(rand()), 0, 5)),
        ]);
    }

    public function newOrder(): View
    {
        return view('admin.newOrder');
    }

    public function saveCustomer(Request $request): RedirectResponse
    {
        DB::table('calendar')->insert([
            'name' => $request->get('name'),
            'date' => $request->get('date'),
            'variant' => $request->get('variant'),
            'description' => $request->get('message'),
            'isDone' => 0,
        ]);
        DB::table('customers')->where('fullname', $request->get('name'))->update([
            'hasTerm' => $request->get('date'),
        ]);

        return back()->with('success', 'Zákazník byl úspěšně přidán do kalendáře');
    }

    public function saveInvoice(Request $request): RedirectResponse
    {
        DB::table('invoices')->insert([
            'type' => $request->get('type'),
            'date' => $request->get('date'),
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'worker' => $request->get('worker'),
        ]);
        DB::table('calendar')->where('name', $request->get('name'))->update([
            'isInvoiceCreated' => 1,
        ]);

        return back()->with('success', 'Faktura byla úspěšně vytvořena');
    }

    public function generateInvoice(int $id): BinaryFileResponse
    {
        $data = DB::table('invoices')->where('id', $id)->first();

        if (!file_exists(storage_path('app/public/invoice'))) {
            mkdir(storage_path('app/public/invoice'));
        }
        $image = imagecreatefromjpeg(public_path('images/invoice/template.jpg'));
        $color = imagecolorallocate($image, 0, 0, 0);
        $font = public_path('fonts/Rubik.ttf');
        imagettftext($image, 20, 0, 800, 100, $color, $font, $data->id);
        imagettftext($image, 20, 0, 500, 150, $color, $font, date_create_from_format('Y-m-d', $data->date)->format('d. n.'));
        imagettftext($image, 20, 0, 800, 150, $color, $font, substr(date_create_from_format('Y-m-d', $data->date)->format('Y'), -2));
        imagettftext($image, 20, 0, 250, 200, $color, $font, $data->name);
        imagettftext($image, 20, 0, 250, 340, $color, $font, 'Čištění interiéru auta');
        imagettftext($image, 20, 0, 200, 410, $color, $font, $data->price);
        imagettftext($image, 20, 0, 500, 540, $color, $font, 'Štěpán Dub, '. date('d. m. Y'));

        imagepng($image, storage_path('app/public/invoice/'.$id.'.png'));

        return response()->download(storage_path('app/public/invoice/'.$id.'.png'));
    }

    public function saveCalendarEvent(Request $request): RedirectResponse
    {
        DB::table('calendar')->insert([
            'date' => $request->get('date'),
            'name' => $request->get('name'),
            'variant' => $request->get('variant'),
            'description' => $request->get('message'),
            'isDone' => 0,
        ]);

        return back()->with('success', 'Zákazník byl úspěšně přidán do kalendáře');
    }

    public function generateVoucher(int $price): BinaryFileResponse
    {
        $hash = substr(md5(date('d. m. Y H:i:s')), 0, 6);
        DB::table('vouchers')->insert([
            'hash' => $hash,
            'date' => date('d-m-Y', strtotime('+1 year')),
            'price' => $price,
        ]);

        if (!file_exists(storage_path('app/public/voucher'))) {
            mkdir(storage_path('app/public/voucher'));
        }
        $image = imagecreatefrompng(public_path('images/vouchers/template.png'));
        $color = imagecolorallocate($image, 0, 0, 0);
        $font = public_path('fonts/Rubik.ttf');
        imagettftext($image, 32, 0, 800, 740, $color, $font, date('d. m. Y', strtotime('+1 year')));
        imagettftext($image, 32, 0, 1410, 740, $color, $font, $hash);

        imagepng($image, storage_path('app/public/voucher/'.$hash.'.png'));

        return response()->file(storage_path('app/public/voucher/'.$hash.'.png'));
    }

    /**
     * @throws Exception
     */
    public function validateVoucher(Request $request): View
    {
        $voucher = DB::table('vouchers')->where('hash', $request->get('hash'))->first();
        if (!$voucher) {
            return view('admin.vouchers', [
                'checkedVoucher' => [
                    'status' => 'red',
                    'message' => 'Voucher neexistuje!',
                    'hash' => '',
                    'price' => 0,
                    'issuer' => '',
                    'dateFrom' => '',
                    'dateTo' => '',
                ]
            ]);
        } else {
            $dateFrom = str_starts_with($voucher->hash, 'x') ? (new DateTime($voucher->date))->modify('-3 months') : (new DateTime($voucher->date))->modify('-1 year');
            if ($request->get('hash') === substr($voucher->hash, 0, 6) && ! $voucher->isAccepted) {
                return view('admin.vouchers', [
                    'checkedVoucher' => [
                        'status' => 'green',
                        'message' => 'Voucher je platný!',
                        'hash' => $voucher->hash,
                        'price' => $voucher->price,
                        'issuer' => $voucher->issuer,
                        'dateFrom' => $dateFrom,
                        'dateTo' => (new DateTime($voucher->date)),
                    ]
                ]);
            } else {
                return view('admin.vouchers', [
                    'checkedVoucher' => [
                        'status' => 'red',
                        'message' => 'Voucher již není platný!',
                        'hash' => $voucher->hash,
                        'price' => $voucher->price,
                        'issuer' => $voucher->issuer,
                        'dateFrom' => $dateFrom,
                        'dateTo' => (new DateTime($voucher->date)),
                    ]
                ]);
            }
        }
    }

    public function useVoucher(Request $request): View
    {
        DB::table('vouchers')->where('hash', $request->get('hash'))->update([
            'isAccepted' => 1,
        ]);

        return view('admin.vouchers', [
            'vouchers' => DB::table('vouchers')->where('isAccepted', 0)->orderBy('date', 'desc')->get(),
            'hex' => 'x'.strtoupper(substr(md5(rand()), 0, 5)),
        ])->with('success', 'Voucher byl úspěšně použit!');
    }

    public function showVoucher(Request $request): RedirectResponse
    {
        /* TODO dodelat FPDI komponentu na vepisovani do voucheru */
        return redirect(asset('images/vouchers/poukaz_'.$request->get('price').'.pdf'));
    }

    public function generateMiniVoucher(string $hex): RedirectResponse
    {
        DB::table('vouchers')->insert([
            'hash' => $hex,
            'date' => date('d-m-Y', strtotime('+3 months')),
            'price' => 0,
        ]);

        return back()->with('success', 'Voucher <strong>'.$hex.'</strong> byl úspěšně vytvořen!');
    }

    public function showErrorLog(string $type): View
    {
        $log = file_get_contents(storage_path('logs/'.$type.'.log'));

        return view('admin.errorlog', [
            'log' => $log,
        ]);
    }
}
