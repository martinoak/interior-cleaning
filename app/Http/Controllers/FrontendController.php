<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormEmail;
use App\Mail\FeedbackEmail;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function tailwind()
    {
        return view('tailwind');
    }

    public function formWithVariant($id)
    {
        Session::put('variant', $id);
        return redirect(url()->previous() . '#kontakt');
    }

    public function sendEmail(Request $request)
    {
        $details = [
            'title' => 'Přišla nová poptávka!',
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'message' => $request->get('message'),
            'variant' => $request->get('variant')
        ];

        Mail::to('oakk.martin@gmail.com')->send(new FormEmail($details));
        return back();
    }

    public function sendFeedbackEmail()
    {
        Mail::to('oakk.martin@gmail.com')->send(new FeedbackEmail());
    }

    public function saveFeedback(Request $request)
    {
        return view('feedback', [
            'hash' => $request->get('id')
        ]);
    }
}
