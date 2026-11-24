<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommissionMenuController extends Controller
{
    public function index()
    {
        return view('artist.menus.index');
    }
    
    public function create_menu()
    {
        return view('artist.menus.form_create_menu');
    }
}
