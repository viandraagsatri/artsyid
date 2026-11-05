<?php

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller; 

class LupaPasswordController extends Controller
{
    public function index() {
        return view('auth.lupa-password');
    }
}