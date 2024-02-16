<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InvoicesController extends Controller
{
    public function index(): View
    {
        $earnings = 0;
        foreach (Invoice::all() as $invoice) {
            $invoice->type === 'N' ? $earnings -= $invoice->price : $earnings += $invoice->price;
        }
        return view('admin.invoices.index', [
            'invoices' => Invoice::orderBy('date', 'desc')->get(),
            'earnings' => $earnings,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): BinaryFileResponse
    {
        $data = Invoice::find($id);

        if (!file_exists(storage_path('app/public/invoice'))) {
            mkdir(storage_path('app/public/invoice'));
        }
        $image = imagecreatefromjpeg(public_path('images/invoice/template.jpg'));
        $color = imagecolorallocate($image, 0, 0, 0);
        $font = public_path('fonts/Rubik.ttf');
        imagettftext($image, 20, 0, 800, 100, $color, $font, utf8_decode($data->id));
        imagettftext($image, 20, 0, 500, 150, $color, $font, \DateTime::createFromFormat('Y-m-d H:i:s', $data->date)->format('d. n.'));
        imagettftext($image, 20, 0, 800, 150, $color, $font, substr(\DateTime::createFromFormat('Y-m-d H:i:s', $data->date)->format('Y'), -2));
        imagettftext($image, 20, 0, 250, 200, $color, $font, utf8_decode($data->name));
        imagettftext($image, 20, 0, 250, 340, $color, $font, 'Čištění interiéru auta');
        imagettftext($image, 20, 0, 200, 410, $color, $font, utf8_decode($data->price));
        imagettftext($image, 20, 0, 500, 540, $color, $font, utf8_decode('Štěpán Dub, '. date('d. m. Y')));

        imagepng($image, storage_path('app/public/invoice/'.$id.'.png'));

        return response()->download(storage_path('app/public/invoice/'.$id.'.png'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        return view('admin.invoices.edit', [
            'invoice' => Invoice::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        Invoice::find($id)->update($request->all());

        return to_route('invoices.index');
    }
}
