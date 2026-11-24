<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function store(LoginRequest $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->is_blocked) {
                $reason = Auth::user()->block_reason;

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = 'Akun Anda telah diblokir.' . ($reason ? "\nAlasan: " . $reason : '');

                return back()->withInput($request->only('email'))->with('error', $message);
            }

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
