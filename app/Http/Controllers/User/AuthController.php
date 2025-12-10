<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // FORM LOGIN USER
    public function loginForm()
    {
        // Jika sudah login, redirect ke home
        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect()->route('user.movies.index');
        }

        return view('user.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'customer') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Anda bukan customer.',
                ]);
            }

            return redirect()->route('movies.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
