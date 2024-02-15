<?php

namespace App\Http\Controllers;

use App\Models\Facades\DatabaseFacade;
use App\Models\Voucher;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VouchersController extends Controller
{
    public function __construct(
        private readonly DatabaseFacade $facade,
    ) {
    }
    public function index(): View
    {
        return view('admin.vouchers.index', [
            'vouchers' => Voucher::where(['accepted' => 0])->orderBy('date', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse|BinaryFileResponse
    {
        $code = md5(rand());

        if ($request->input('type') === 'mini') {
            $hex = 'x'.strtoupper(substr($code, 0, 5));
            $this->facade->saveVoucher($hex, '+3 months');

            return to_route('vouchers.index')->with('success', 'Voucher <strong>'.$hex.'</strong> byl úspěšně vytvořen!');
        } else {
            $hash = substr($code, 0, 6);
            $this->facade->saveVoucher($hash, '+1 year', $request->input('price'));

            file_exists(storage_path('app/public/voucher')) || mkdir(storage_path('app/public/voucher'));
            $image = imagecreatefrompng(public_path('images/vouchers/template.png'));
            $color = imagecolorallocate($image, 0, 0, 0);
            $font = public_path('fonts/Rubik.ttf');
            imagettftext($image, 32, 0, 800, 740, $color, $font, date('d. m. Y', strtotime('+1 year')));
            imagettftext($image, 32, 0, 1410, 740, $color, $font, $hash);

            imagepng($image, storage_path('app/public/voucher/'.$hash.'.png'));

            return response()->download(storage_path('app/public/voucher/'.$hash.'.png'));
        }
    }

    public function show(Request $request, string $id): RedirectResponse
    {
        /* TODO */
        return redirect(asset('images/vouchers/poukaz_'.$request->get('price').'.pdf'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // TODO
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO
    }

    /**
     * @throws Exception
     */
    public function validateVoucher(Request $request): View
    {
        $voucher = Voucher::find($request->get('hash'));
        if (!$voucher) {
            return view('admin.vouchers.validate', [
                'voucher' => [
                    'status' => 'red',
                    'message' => 'Voucher neexistuje!',
                    'hash' => '',
                    'price' => 0,
                    'dateFrom' => '',
                    'dateTo' => '',
                ]
            ]);
        } else {
            $dateFrom = str_starts_with($voucher->hash, 'x') ? (new DateTime($voucher->date))->modify('-3 months') : (new DateTime($voucher->date))->modify('-1 year');
            if ($request->get('hash') === substr($voucher->hash, 0, 6) && !$voucher->accepted) {
                return view('admin.vouchers.validate', [
                    'voucher' => [
                        'status' => 'green',
                        'message' => 'Voucher je platný!',
                        'hash' => $voucher->hash,
                        'price' => $voucher->price,
                        'dateFrom' => $dateFrom,
                        'dateTo' => (new DateTime($voucher->date)),
                    ]
                ]);
            } else {
                return view('admin.vouchers.validate', [
                    'voucher' => [
                        'status' => 'red',
                        'message' => 'Voucher již není platný!',
                        'hash' => $voucher->hash,
                        'price' => $voucher->price,
                        'dateFrom' => $dateFrom,
                        'dateTo' => (new DateTime($voucher->date)),
                    ]
                ]);
            }
        }
    }

    public function useVoucher(Request $request): RedirectResponse
    {
        Voucher::find($request->get('hash'))->update(['accepted' => 1]);

        return to_route('vouchers.index')->with('success', 'Voucher byl úspěšně použit!');
    }
}
