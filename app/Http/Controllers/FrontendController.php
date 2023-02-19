<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormEmail;
use App\Mail\FeedbackEmail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index', [
            'feedbacks' => DB::table('feedback')->where([['rating', '>', 3]])->get(),
            'dev' => preg_match('#dev\.#', url()->current())
        ]);
    }

    public function archiveMember($id): RedirectResponse
    {
        DB::table('contact_form_inputs')->where('id', $id)->update(['isArchived' => 1]);
        return back();
    }

    public function formWithVariant($id)
    {
        Session::put('variant', $id);
        return redirect(url()->previous() . '#kontakt');
    }

    public function sendEmail(Request $request): RedirectResponse
    {
        $details = [
            'title' => 'Přišla nová poptávka!',
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'message' => $request->get('message'),
            'variant' => $request->get('variant') ?? 'Není vyplněná varianta',
        ];

        DB::table('contact_form_inputs')->insert([
            'fullname' => $details['name'],
            'email' => $details['email'],
            'telephone' => $details['phone'],
            'message' => $details['message'],
        ]);

        Mail::to('info@cisteni-kondrac.cz')->send(new FormEmail($details));
        return back();
    }

    public function sendFeedbackEmail(Request $request): RedirectResponse
    {
        Mail::to($request->get('email'))->send(new FeedbackEmail($request->get('variant')));
        DB::table('contact_form_inputs')->where('email', $request->get('email'))->update([
            'feedbackSent' => 1,
        ]);
        return back()->with('success', 'Feedback email odeslán!');
    }

    public function newFeedback(Request $request): View
    {
        return view('feedback', [
            'hash' => $request->get('id'),
            'variant' => $request->get('variant')
        ]);
    }

    public function storeFeedback(Request $request)
    {
        if ($request->get('variant') == 1) {
            $variant = 'Lehký start';
        } else if ($request->get('variant') == 2) {
            $variant = 'Zlatá střední cesta';
        } else {
            $variant = 'Deluxe';
        }

        DB::table('feedback')->insert([
            'hash' => $request->get('hash'),
            'fullname' => $request->get('fullname'),
            'message' => $request->get('message'),
            'rating' => $request->get('stars'),
            'variant' => $variant,
        ]);

        return redirect(route('homepage'));
    }

    public function deleteFeedback(int $id): RedirectResponse
    {
        DB::table('feedback')->where('id', $id)->delete();
        return back();
    }

    public function showDashboard() {
        return view('admin.dashboard', [
            'contactFormMembers' => DB::table('contact_form_inputs')->where('isArchived', 0)->get(),
            'dev' => preg_match('#dev\.#', url()->current())
        ]);
    }

    public function showCalendar() {
        return view('admin.calendar', [
            'orders' => DB::table('calendar')->get()->where('isDone', 0)->sortBy('date'),
            'fOrders' => DB::table('calendar')->get()->where('isDone', 1),
        ]);
    }

    public function showFeedback(): View {
        return view('admin.feedbacks', [
            'feedbacks' => DB::table('feedback')->get(),
        ]);
    }

    public function showInvoices() {
        return view('admin.invoices', [
            'invoices' => DB::table('invoices')->get(),
        ]);
    }

    public function showCustomers() {
        return view('admin.customers', [
            'customers' => DB::table('contact_form_inputs')->where('isArchived', 1)->get(),
        ]);
    }

    public function showVouchers() {
        return view('admin.vouchers');
    }

    public function checkVoucher(Request $request): JsonResponse {
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

    public function newOrder() {
        return view('admin.newOrder');
    }

    public function saveCustomer(Request $request): RedirectResponse {
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

    public function saveInvoice(Request $request): RedirectResponse {
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

        return back()->with('success', 'Zákazník byl úspěšně přidán do kalendáře');
    }

    public function exportInvoice(int $invoiceId)
    {
        $pdf = new FPDF();
        /*TODO*/
    }

    public function saveCalendarEvent(Request $request): RedirectResponse {
        DB::table('calendar')->insert([
            'date' => $request->get('date'),
            'name' => $request->get('name'),
            'variant' => $request->get('variant'),
            'description' => $request->get('message'),
            'isDone' => 0,
        ]);
        return back()->with('success', 'Zákazník byl úspěšně přidán do kalendáře');
    }

    public function storeVoucher(Request $request): View {
        $hash = substr(md5(date('d. m. Y H:i:s')), 0, 6);
        DB::table('vouchers')->insert([
            'hash' => $hash,
            'date' => date('d-m-Y', strtotime('+6 months')) /* TODO expirace 6 mesicu? */,
            'price' => $request->get('price'),
        ]);

        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile(asset('images/vouchers/poukaz_'.$request->get('price').'.pdf'));
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);

        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->setXY(100, 50);
        $pdf->Cell(0, 0, 'Poukaz na služby');

        $filename = 'poukaz_'.substr($hash, 0, 4).'.pdf';
        $pdf->Output(asset('images/vouchers'), $filename);

        /* TODO nadesignovat vykreslovani voucheru pomoci FPDF */

        return view('admin.vouchers', ['voucher' => [
            'hash' => $hash,
            'date' => date('d-m-Y', strtotime('+6 months')),
            'price' => $request->get('price'),
        ]]);
    }


    public function validateVoucher(Request $request): View
    {
        $voucher = DB::table('vouchers')->where('hash', $request->get('hash'))->first();
        if($voucher && $request->get('hash') === substr($voucher->hash, 0, 6) && $voucher->price === (int)$request->get('price') && !$voucher->isAccepted) {
            return view('admin.vouchers', ['checkedVoucher' => [
                'status' => 'green',
                'message' => 'Voucher je platný!',
                'hash' => $voucher->hash,
                'price' => $voucher->price,
            ]]);
        }
        else {
            return view('admin.vouchers', ['checkedVoucher' => [
                'status' => 'red',
                'message' => 'Voucher není platný nebo neexistuje!',
            ]]);
        }
    }

    public function useVoucher(Request $request): View {
        DB::table('vouchers')->where('hash', $request->get('hash'))->update([
            'isAccepted' => 1,
        ]);
        return view('admin.vouchers')->with('success', 'Voucher byl úspěšně použit!');
    }

    public function generateVoucher(Request $request) {
        /* TODO dodelat FPDI komponentu na vepisovani do voucheru */
        return redirect(asset('images/vouchers/poukaz_'.$request->get('price').'.pdf'));
    }
}
