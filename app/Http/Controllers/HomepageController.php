<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use App\Http\Requests\NewDemandRequest;
use App\Mail\FeedbackEmail;
use App\Mail\FormEmail;
use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomepageController extends Controller
{
    public function index(): View
    {
        $pricelist = [];

        foreach (CleaningTypes::cases() as $case) {
            $pricelist[$case->value] = [
                'price' => $case->getVariantPrice(),
                'description' => $case->getVariantDescription(),
            ];
        }

        return view('home', [
            'feedbacks' => Feedback::all(),
            'pricelist' => $pricelist,
        ]);
    }

    public function sendEmail(NewDemandRequest $request): RedirectResponse
    {
        $secretKey = env('GOOGLE_RECAPTCHA_SECRET_KEY');
        $responseKey = $request->get('recaptcha_response');
        $ip = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$ip";
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            Log::info('Recaptcha failed', ['data' => $request->all()]);
            abort(403, 'Recaptcha failed');
        }

        Customer::create($request->all());

        Mail::to('stepan@cisteni-kondrac.cz')->send(new FormEmail($request->all()));

        return back()->with('success', 'Email odeslán!');
    }

    public function sendFeedbackEmail(Request $request): RedirectResponse
    {
        $to = $request->get('email');
        if (!$to) {
            return back()->with('error', 'Email není vyplněný!');
        } else {
            Mail::to($request->get('email'))
                ->send(new FeedbackEmail(md5(time()), CleaningTypes::from($request->get('variant'))->value));

            Customer::where('id', $request->get('id'))->update(['feedbackSent' => 1]);

            return back()->with('success', 'Feedback email odeslán!');
        }
    }

    public function newFeedback(Request $request): View
    {
        return view('feedback', [
            'hash' => $request->get('id'),
            'customer' => $request->get('customer'),
            'variant' => $request->get('variant'),
        ]);
    }

    public function storeFeedback(Request $request): RedirectResponse
    {
        if (Feedback::where('hash', $request->input('hash'))->exists()) {
            return back()->with('error', 'Tento feedback již byl odeslán, děkujeme.');
        } else {
            Feedback::create($request->all())->save();

            return to_route('homepage')->with('success', 'Feedback odeslán, děkujeme.');
        }
    }
}
