<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormEmail;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function sendEmail(Request $request)
    {
        $details = [
            'title' => 'Přišla nová poptávka!',
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'message' => $request->get('message')
        ];

        Mail::to("oakk.martin@gmail.com")->send(new FormEmail($details));
        return back();
    }
}
