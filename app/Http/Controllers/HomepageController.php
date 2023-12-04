<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use App\Mail\FeedbackEmail;
use App\Mail\FormEmail;
use App\Models\Facades\DatabaseFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomepageController extends Controller
{
    public function __construct(
        private readonly DatabaseFacade $facade,
    ) {
    }

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
            'feedbacks' => $this->facade->getFeedbacks(),
            'pricelist' => $pricelist,
        ]);
    }

    public function sendEmail(Request $request): RedirectResponse
    {
        $this->facade->saveCustomer($request->all());

        Mail::to('stepan@cisteni-kondrac.cz')
            ->bcc('martin.dub@dek-cz.com')
            ->send(new FormEmail($request->all()));

        return back()->with('success', 'Email odeslán!');
    }

    public function sendFeedbackEmail(Request $request): RedirectResponse
    {
        Mail::to($request->get('email'))
            ->bcc('martin.dub@dek-cz.com')
            ->send(new FeedbackEmail(CleaningTypes::from($request->get('variant'))->value));
        $this->facade->setFeedbackSent($request->get('id'));

        return back()->with('success', 'Feedback email odeslán!');
    }

    public function setVariant(Request $request): RedirectResponse
    {
        $this->facade->setVariant($request->get('id'), $request->get('variant'));

        return back()->with('success', 'Varianta nastavena!');
    }

    public function newFeedback(Request $request): View
    {
        return view('feedback', [
            'hash' => $request->get('id'),
            'variant' => $request->get('variant'),
        ]);
    }

    public function storeFeedback(Request $request): RedirectResponse
    {
        $isDuplicity = $this->facade->getFeedbackByHash($request->get('hash'));

        if ($isDuplicity) {
            return back()->with('error', 'Tento feedback již byl odeslán, děkujeme.');
        } else {
            $this->facade->saveFeedback($request->all(), $request->get('variant'));

            return redirect(route('homepage'));
        }
    }
}
