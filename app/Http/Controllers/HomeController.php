<?php

namespace App\Http\Controllers;

use App\Services\PublicCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly PublicCatalogService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getLandingPageData(
            $request->only(['category', 'sort'])
        );

        return view('home', $data);
    }
}
