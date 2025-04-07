<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CleaningTypes;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Voucher;
use DateTime;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VouchersController extends Controller
{
    public function index(): View
    {
        return view('admin.vouchers.index', [
            'vouchers' => Voucher::where(['accepted' => 0, 'expired' => 0])->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse|BinaryFileResponse
    {
        if ($request->input('type') === 'mini') {
            $hash = 'x'.strtoupper(substr(md5(rand()), 0, 5));
            Voucher::create([
                'hash' => $hash,
                'date' => DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->modify('+3 months')->format('Y-m-d'),
                'price' => 0,
            ]);

            return to_route('vouchers.index')->with('success', "Voucher <strong>$hash</strong> byl úspěšně vytvořen!")->with('voucher', $hash);
        } elseif ($request->input('type') === 'regular') {
            $type = Str::slug(CleaningTypes::from($request->input('variant'))->getShortenedTitle());
            $hash = strtoupper(substr(md5(rand()), 0, 6));
            $price = CleaningTypes::from($request->input('variant'))->getRawPrice();
            Voucher::create([
                'hash' => $hash,
                'date' => DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->modify('+1 year')->format('Y-m-d'),
                'price' => $price,
            ]);

            Invoice::create([
                'type' => 'P',
                'date' => DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->format('Y-m-d'),
                'name' => $hash,
                'price' => $price,
                'worker' => 'S',
            ]);

            file_exists(storage_path('app/public/voucher')) || mkdir(storage_path('app/public/voucher'));
            $image = imagecreatefrompng(public_path("images/vouchers/$type.png"));
            $color = imagecolorallocate($image, 0, 0, 0);
            $font = public_path('fonts/Ciutadella.ttf');

            $date_text = date('d. m. Y', strtotime('+1 year'));

            imagettftext($image, 32, 0, 780, 720, $color, $font, $date_text);
            imagettftext($image, 32, 0, 1460, 720, $color, $font, $hash);

            imagepng($image, storage_path("app/public/voucher/$hash.png"));

            return response()->download(storage_path("app/public/voucher/$hash.png"));
        }

        return to_route('vouchers.index')->with('success', 'Voucher byl úspěšně vytvořen!');
    }

    public function show(string $voucher): BinaryFileResponse|RedirectResponse
    {
        $file = storage_path("app/public/voucher/$voucher.png");
        if (file_exists($file)) {
            return response()->download($file);
        } else {
            return back()->with('error', 'Náhled voucheru neexistuje!');
        }
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
                ],
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
                    ],
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
                    ],
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
