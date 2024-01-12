<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use App\Models\Facades\DatabaseFacade;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    public function __construct(
        private readonly DatabaseFacade $facade,
    ) {
    }

    public function archiveCustomer($id): RedirectResponse
    {
        $this->facade->archiveCustomer($id);
        $this->facade->saveInvoice($id);

        return back()->with('success', 'Zákazník byl archivován');
    }

    public function deleteCustomer(int $id): RedirectResponse
    {
        $this->facade->deleteCustomer($id);

        return back()->with('success', 'Zákazník byl smazán');
    }

    /**
     * @throws Exception
     */
    public function showDashboard(): View
    {
        if (!file_exists(storage_path('logs/cron.log'))) {
            file_put_contents(storage_path('logs/cron.log'), '');
        }

        $invoices = $this->facade->getInvoices();
        $earnings = [];

        foreach ($invoices as $i) {
            $year = date('Y', strtotime($i->date));
            $earnings[$year] = ['01' => 0, '02' => 0, '03' => 0, '04' => 0, '05' => 0, '06' => 0, '07' => 0, '08' => 0, '09' => 0, '10' => 0, '11' => 0, '12' => 0];
        }

        foreach ($invoices as $i) {
            $year = date('Y', strtotime($i->date));
            if ($i->type === 'N') {
                $earnings[$year][date('m', strtotime($i->date))] -= $i->price;
            } else {
                $earnings[$year][date('m', strtotime($i->date))] += $i->price;
            }
        }

        $annual = 0;
        foreach ($this->facade->getThisYearInvoices() as $a) {
            if ($a->type === 'N') {
                $annual -= $a->price;
            } else {
                $annual += $a->price;
            }
        }

        $month = 0;
        foreach ($this->facade->getThisMonthInvoices() as $m) {
            if ($m->type === 'N') {
                $month -= $m->price;
            } else {
                $month += $m->price;
            }
        }

        return view('admin.admin', [
            'customers' => $this->facade->getNotArchivedCustomers(),
            'calendar' => $this->facade->getFirstFutureCustomer(),
            'annual' => $annual,
            'month' => $month,
            'variants' => [
                CleaningTypes::START->value => $this->facade->getTotalVariants(CleaningTypes::START),
                CleaningTypes::MIDDLE->value => $this->facade->getTotalVariants(CleaningTypes::MIDDLE),
                CleaningTypes::DELUXE->value => $this->facade->getTotalVariants(CleaningTypes::DELUXE),
            ],
            'earnings' => $earnings,
        ]);
    }

    public function showFeedback(): View
    {
        return view('admin.feedbacks', [
            'feedbacks' => $this->facade->getFeedbacks(),
        ]);
    }

    public function refreshFeedbacks(): RedirectResponse
    {
        Artisan::call('app:get-reviews');

        return back()->with('success', 'Recenze z Google Map importovány!');
    }

    public function showInvoices(): View
    {
        return view('admin.invoices', [
            'invoices' => $this->facade->getInvoices(),
        ]);
    }

    public function showCustomers(): View
    {
        return view('admin.customers', [
            'customers' => $this->facade->getCustomers(['isArchived' => 0]),
            'archived' => $this->facade->getCustomers(['isArchived' => 1]),
        ]);
    }

    public function showVouchers(): View
    {
        return view('admin.vouchers', [
            'vouchers' => $this->facade->getNotAcceptedVouchers(),
            'hex' => 'x'.strtoupper(substr(md5(rand()), 0, 5)),
        ]);
    }

    public function newOrder(): View
    {
        return view('admin.newOrder');
    }

    public function saveCustomer(Request $request): RedirectResponse
    {
        $this->facade->updateCustomer($request->all());

        return back()->with('success', 'Zákazník byl úspěšně aktualizován!');
    }

    public function showInvoice(int $id): BinaryFileResponse
    {
        $data = $this->facade->getInvoiceById($id);

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

    public function generateVoucher(int $price): BinaryFileResponse
    {
        $hash = substr(md5(time()), 0, 6);
        $this->facade->saveVoucher($hash, '+1 year', $price);

        file_exists(storage_path('app/public/voucher')) || mkdir(storage_path('app/public/voucher'));
        $image = imagecreatefrompng(public_path('images/vouchers/template.png'));
        $color = imagecolorallocate($image, 0, 0, 0);
        $font = public_path('fonts/Rubik.ttf');
        imagettftext($image, 32, 0, 800, 740, $color, $font, date('d. m. Y', strtotime('+1 year')));
        imagettftext($image, 32, 0, 1410, 740, $color, $font, $hash);

        imagepng($image, storage_path('app/public/voucher/'.$hash.'.png'));

        return response()->download(storage_path('app/public/voucher/'.$hash.'.png'));
    }

    /**
     * @throws Exception
     */
    public function validateVoucher(Request $request): View
    {
        $voucher = $this->facade->getVoucherByHash($request->get('hash'));
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
            if ($request->get('hash') === substr($voucher->hash, 0, 6) && !$voucher->isAccepted) {
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
        $this->facade->useVoucher($request->get('hash'));

        return view('admin.vouchers', [
            'vouchers' => $this->facade->getVouchers(['isAccepted' => 0]),
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
        $this->facade->saveVoucher($hex, '+3 months');

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
