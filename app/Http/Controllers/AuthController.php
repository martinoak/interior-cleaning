<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function loginView(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (Auth::attempt($request->only('name', 'password'))) {
            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'Nesprávné přihlašovací údaje');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
