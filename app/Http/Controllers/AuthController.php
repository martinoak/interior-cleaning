<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request): RedirectResponse
    {
        User::create([
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
        ]);

        return back()->with('success', 'Registrace proběhla úspěšně');
    }

    public function showLoginPage()
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
