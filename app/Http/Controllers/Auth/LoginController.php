<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$validation) return back()->with('error', 'Login gagal!');

        $credential = $request->only('email', 'password');

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Email atau password salah');
    }
}
