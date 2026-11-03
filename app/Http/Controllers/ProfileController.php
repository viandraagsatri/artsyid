<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $role = Auth::user()->role;

        if ($role == 'user') {
            return view('user.profile');
        } elseif ($role == 'admin') {
            return view('admin.profile');
        } elseif ($role == 'artist') {
            return view('artist.profile');
        }

        return view('404');
    }
}
