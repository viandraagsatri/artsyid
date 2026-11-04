<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarArtist extends Controller
{
    public function index() {
        return view('daftar_artist');
    }
}
