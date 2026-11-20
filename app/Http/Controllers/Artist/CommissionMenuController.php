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
}
