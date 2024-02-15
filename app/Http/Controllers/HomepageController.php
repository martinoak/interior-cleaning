<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use App\Mail\FeedbackEmail;
use App\Mail\FormEmail;
use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function sendEmail(Request $request): RedirectResponse
    {
        Customer::create($request->all());

        Mail::to('stepan@cisteni-kondrac.cz')->send(new FormEmail($request->all()));

        return back()->with('success', 'Email odeslán!');
    }

    public function sendFeedbackEmail(Request $request): RedirectResponse
    {
        Mail::to($request->get('email'))
            ->send(new FeedbackEmail(md5(time()), CleaningTypes::from($request->get('variant'))->value));

        Customer::where('id', $request->get('id'))->update(['feedbackSent' => 1]);

        return back()->with('success', 'Feedback email odeslán!');
    }

    public function setVariant(Request $request): RedirectResponse
    {
        Customer::find($request->get('id'))->update(['variant' => $request->get('variant')]);

        return back()->with('success', 'Varianta nastavena!');
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
