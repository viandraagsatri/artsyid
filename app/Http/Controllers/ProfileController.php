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
            return redirect()->route('profile.katalog');
        }

        return view('404');
    }

    public function katalog() 
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        return view('artist.profile.katalog');
    }

    public function portofolio() 
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        return view('artist.profile.portofolio');
    }

    public function settings() 
    {
        return view('artist.profile.setting');
    }

    public function getPortofolio()
    {
        $portofolios = Portofolio::where('artist_id', Auth::user()->id)->get();
        return view('artist.profile.portofolio', compact('portofolios'));
    }
}
