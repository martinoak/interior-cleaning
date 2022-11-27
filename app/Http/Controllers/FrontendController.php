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

    public function dashboard()
    {
        return view('dashboard', [
            'contactFormMembers' => DB::table('contact_form_inputs')->get()
        ]);
    }

    public function deleteMember($id)
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

    public function sendFeedbackEmail()
    {
        Mail::to('oakk.martin@gmail.com')->send(new FeedbackEmail());
    }

    public function newFeedback(Request $request): View
    {
        return view('feedback', [
            'hash' => $request->get('id')
        ]);
    }

    public function storeFeedback(Request $request)
    {
        DB::table('feedback')->insert([
            'hash' => $request->get('hash'),
            'fullname' => $request->get('fullname'),
            'message' => $request->get('message'),
            'rating' => $request->get('stars'),
            'variant' => $request->get('variant')
        ]);

        return redirect(route('homepage'));
    }
}
