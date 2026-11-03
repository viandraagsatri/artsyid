<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Katalog extends Controller
{
    public function index() {
        return view('katalog.katalog');
    }

    public function detail($id = null) {
        return view('katalog.detail_katalog', compact('id'));
    }
}
