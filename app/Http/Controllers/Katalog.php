<?php

namespace App\Http\Controllers;

use App\Services\PublicCatalogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Katalog extends Controller
{
    public function __construct(
        private readonly PublicCatalogService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getCatalogPageData(
            $request->only(['search', 'category', 'open_slot', 'price_range', 'duration', 'rating', 'sort'])
        );

        return view('katalog.katalog', $data);
    }

    public function detail(Request $request, int $id): View
    {
        $data = $this->service->getCatalogDetailData($id, $request->user());

        return view('katalog.detail_katalog', $data);
    }
}
