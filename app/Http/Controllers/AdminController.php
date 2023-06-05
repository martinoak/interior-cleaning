<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function archiveMember($id): RedirectResponse
    {
        DB::table('contact_form_inputs')->where('id', $id)->update(['isArchived' => 1]);

        return back()->with('success', 'Zákazník byl archivován');
    }

    public function showDashboard(): View
    {
        return view('admin.dashboard', [
            'contactFormMembers' => DB::table('contact_form_inputs')->where('isArchived', 0)->get(),
            'dev' => preg_match('#dev\.#', url()->current()),
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

    public function showInvoices()
    {
        return view('admin.invoices', [
            'invoices' => DB::table('invoices')->orderBy('date', 'desc')->get(),
        ]);
    }

    public function showCustomers()
    {
        return view('admin.customers', [
            'customers' => DB::table('contact_form_inputs')->where('isArchived', 1)->orderBy('id', 'desc')->get(),
        ]);
    }

    public function showVouchers()
    {
        return view('admin.vouchers', [
            'hex' => 'x'.strtoupper(substr(md5(rand()), 0, 5)),
        ]);
    }

    public function checkVoucher(Request $request): JsonResponse
    {
        $hash = md5($request->get('date').$request->get('price'));
        $voucher = DB::table('vouchers')->where('hash', $hash)->first();
        if ($voucher) {
            return response()->json([
                'status' => 'green',
                'message' => 'Voucher je platný!',
                'price' => $voucher->price,
            ]);
        } else {
            return response()->json([
                'status' => 'red',
                'message' => 'Voucher není platný!',
            ]);
        }
    }

    public function newOrder()
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
        DB::table('contact_form_inputs')->where('fullname', $request->get('name'))->update([
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

    public function makeInvoice(int $id)
    {
        /* TODO */
        $img = imagecreatefromjpeg(asset('images/invoice/template.jpg'));

        return asset('images/invoice/template.jpg');
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

    public function storeVoucher(Request $request): View
    {
        $hash = substr(md5(date('d. m. Y H:i:s')), 0, 6);
        DB::table('vouchers')->insert([
            'hash' => $hash,
            'date' => date('d-m-Y', strtotime('+6 months')) /* TODO expirace 6 mesicu? */,
            'price' => $request->get('price'),
        ]);

        return view('admin.vouchers', ['voucher' => [
            'hash' => $hash,
            'date' => date('d-m-Y', strtotime('+6 months')),
            'price' => $request->get('price'),
        ]]);
    }

    public function validateVoucher(Request $request): View
    {
        $voucher = DB::table('vouchers')->where('hash', $request->get('hash'))->first();
        if ($voucher && $request->get('hash') === substr($voucher->hash, 0, 6) && $voucher->price === (int) $request->get('price') && ! $voucher->isAccepted) {
            return view('admin.vouchers', ['checkedVoucher' => [
                'status' => 'green',
                'message' => 'Voucher je platný!',
                'hash' => $voucher->hash,
                'price' => $voucher->price,
            ]]);
        } else {
            return view('admin.vouchers', [
                'checkedVoucher' => [
                    'status' => 'red',
                    'message' => 'Voucher není platný nebo neexistuje!',
                ]
            ]);
        }
    }

    public function useVoucher(Request $request): View
    {
        DB::table('vouchers')->where('hash', $request->get('hash'))->update([
            'isAccepted' => 1,
        ]);

        return view('admin.vouchers', [
            'hex' => 'x'.strtoupper(substr(md5(rand()), 0, 5)),
        ])->with('success', 'Voucher byl úspěšně použit!');
    }

    public function generateVoucher(Request $request)
    {
        /* TODO dodelat FPDI komponentu na vepisovani do voucheru */
        return redirect(asset('images/vouchers/poukaz_'.$request->get('price').'.pdf'));
    }

    public function saveMiniVoucher(string $hex): RedirectResponse
    {
        DB::table('vouchers')->insert([
            'hash' => $hex,
            'date' => date('d-m-Y', strtotime('+3 months')),
            'price' => 0,
        ]);

        return back()->with('success', 'Voucher byl úspěšně vytvořen!');
    }
}
