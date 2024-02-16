<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function index(): View
    {
        return view('admin.customers.index', [
            'customers' => Customer::where('archived', 0)->get(),
            'archived' => Customer::where('archived', 1)->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Customer::create($request->all());

        return back()->with('success', 'Zákazník byl úspěšně přidán!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        Customer::find($id)->update($request->all());

        return back()->with('success', 'Zákazník byl úspěšně aktualizován!');
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
}
