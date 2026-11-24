<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        $portofolios = Portfolio::where('artist_id', Auth::id())
                                ->latest()
                                ->get();
        return view('artist.portfolios.index', compact('portofolios'));
    }

    public function create_portofolio()
    {
        return view('artist.portfolios.form_create_portofolio');
    }
    

}
