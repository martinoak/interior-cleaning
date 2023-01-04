<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request): RedirectResponse
    {
        User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return back()->with('success', 'Registrace proběhla úspěšně');
    }

    public function showLoginPage() {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'Nesprávné přihlašovací údaje');
        }
    }
}
