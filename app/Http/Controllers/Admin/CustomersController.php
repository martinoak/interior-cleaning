<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CleaningTypes;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomersController extends Controller
{
    public function index(): View
    {
        return view('admin.customers.index', [
            'customers' => Customer::where('archived', 0)->get(),
            'archived' => Customer::where('archived', 1)->orderBy('id', 'desc')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Customer::create($request->all());

        return to_route('customers.index')->with('success', 'Zákazník byl úspěšně přidán!');
    }

    public function edit(string $id): View
    {
        return view('admin.customers.edit', [
            'customer' => Customer::find($id),
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        Customer::find($id)->update($request->all());

        return to_route('customers.index')->with('success', 'Zákazník byl úspěšně aktualizován!');
    }

    public function destroy(string $id): RedirectResponse
    {
        Customer::destroy($id);

        return back()->with('success', 'Zákazník byl smazán');
    }

    public function archive(int $id): RedirectResponse
    {
        Customer::find($id)->update(['archived' => 1]);
        $invoice = Invoice::create([
            'type' => 'T',
            'date' => Customer::find($id)->term,
            'name' => Customer::find($id)->name,
            'price' => CleaningTypes::from(Customer::find($id)->variant)->getRawPrice(),
            'worker' => 'S',
        ]);
        $invoice->save();

        Customer::find($id)->update(['invoice_id' => $invoice->id]);

        return back()->with('success', 'Zákazník byl archivován');
    }

    public function exportCustomers(): StreamedResponse
    {
        $invoices = Invoice::orderBy('date', 'desc')->get();

        $file = fopen('php://temp', 'w');

        foreach ($invoices as $invoice) {
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, [
                utf8_decode($invoice->type),
                $invoice->date,
                $invoice->name,
                $invoice->price,
                $invoice->worker
            ], ';');
        }

        rewind($file);
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers.csv"',
        ];

        return response()->stream(function () use ($file) {
            fpassthru($file);
        }, 200, $headers);
    }
}
