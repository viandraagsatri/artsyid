<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Exception;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, AuthService $service) {
        try {
            $service->register($request->validated());

            return redirect()->route('login')->with('success', 'Registrasi berhasil!');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }
}
