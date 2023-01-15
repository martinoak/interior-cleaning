<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormEmail;
use App\Mail\FeedbackEmail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index', [
            'feedbacks' => DB::table('feedback')->where([['rating', '>', 3]])->get(),
        ]);
    }

    public function deleteMember($id): RedirectResponse
    {
        DB::table('contact_form_inputs')->where('id', $id)->delete();
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

    public function sendFeedbackEmail(Request $request)
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

    public function showDashboard() {
        return view('admin.dashboard', [
            'contactFormMembers' => DB::table('contact_form_inputs')->get(),
            'feedbacks' => DB::table('feedback')->get(),
        ]);
    }

    public function showCalendar() {
        return view('admin.calendar', [
            'orders' => DB::table('calendar')->get()->where('isDone', 0),
            'fOrders' => DB::table('calendar')->get()->where('isDone', 1),
        ]);
    }

    public function showInvoices() {
        return view('admin.invoices', [
            'invoices' => DB::table('invoices')->get(),
        ]);
    }

    public function newOrder() {
        return view('admin.newOrder');
    }

    public function saveCustomer(Request $request): RedirectResponse {
        DB::table('calendar')->insert([
            'name' => $request->get('name'),
            'date' => $request->get('date'),
            'description' => $request->get('message'),
            'isDone' => 0,
        ]);

        return back()->with('success', 'Zákazník byl úspěšně přidán do kalendáře');
    }
}
