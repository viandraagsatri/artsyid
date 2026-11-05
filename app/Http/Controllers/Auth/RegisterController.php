<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request) {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:8',
            ],
            [
                'name.required' => 'Nama wajib diisi!',
                'email.required' => 'Email wajib diisi!',
                'email.email' => 'Format email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password wajib diisi!',
                'password.confirmed' => 'Password tidak cocok!',
                'password.min' => 'Password minimal 8 karakter!',
            ]
        );

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
    
            return redirect()->route('login')->with('success', 'Registrasi berhasil!');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }
}
