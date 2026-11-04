<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $role = Auth::user()->role;

        if ($role === 'user') {
            return view('user.dashboard');
        } else if ($role === 'artist') {
            return view('artist.dashboard');
        } else if ($role === 'admin') {
            return view('admin.dashboard');
        }
    }
}
