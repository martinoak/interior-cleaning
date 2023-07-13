<?php

namespace App\Http\Controllers;

use App\Enums\CleaningTypes;
use App\Mail\FeedbackEmail;
use App\Mail\FormEmail;
use App\Models\Facades\DatabaseFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomepageController extends Controller
{
    public function __construct(
        private readonly DatabaseFacade $dbFacade,
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
            'feedbacks' => $this->dbFacade->getFeedbacks(),
            'pricelist' => $pricelist,
        ]);
    }

    public function sendEmail(Request $request): RedirectResponse
    {
        DB::table('customers')->insert([
            'fullname' => $request->get('name'),
            'email' => $request->get('email'),
            'telephone' => $request->get('phone'),
            'message' => $request->get('message'),
            'variant' => $request->get('variant'),
        ]);

        Mail::to('stepan@cisteni-kondrac.cz')->send(new FormEmail($request->all()));

        return back()->with('success', 'Email odeslán!');
    }

    public function sendFeedbackEmail(Request $request): RedirectResponse
    {
        Mail::to($request->get('email'))->send(new FeedbackEmail(CleaningTypes::from($request->get('variant'))->value));
        $this->dbFacade->setFeedbackSent($request->get('id'));

        return back()->with('success', 'Feedback email odeslán!');
    }

    public function setVariant(Request $request): RedirectResponse
    {
        $this->dbFacade->setVariant($request->get('id'), $request->get('variant'));

        return back()->with('success', 'Varianta nastavena!');
    }

    public function newFeedback(Request $request): \Illuminate\View\View
    {
        return view('feedback', [
            'hash' => $request->get('id'),
            'variant' => $request->get('variant'),
        ]);
    }

    public function storeFeedback(Request $request): RedirectResponse
    {
        $duplicity = DB::table('feedback')->where('hash', $request->get('hash'))->get();

        if (count($duplicity) > 0) {
            return back()->with('error', 'Tento feedback již byl odeslán!');
        } else {
            if ($request->get('variant') == 1) {
                $variant = 'Lehký start';
            } elseif ($request->get('variant') == 2) {
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
    }

    public function deleteFeedback(int $id): RedirectResponse
    {
        DB::table('feedback')->where('id', $id)->delete();

        return back()->with('success', 'Feedback smazán!');
    }
}
