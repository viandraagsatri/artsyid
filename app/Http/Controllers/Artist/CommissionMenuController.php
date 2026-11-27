<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Artist\StoreCommissionAddonRequest;
use App\Http\Requests\Artist\StoreCommissionMenuRequest;
use App\Http\Requests\Artist\UpdateCommissionAddonRequest;
use App\Http\Requests\Artist\UpdateCommissionMenuRequest;
use App\Models\CommissionAddon;
use App\Models\CommissionMenu;
use App\Models\CommissionSample;
use App\Services\ArtistCommissionMenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CommissionMenuController extends Controller
{
    public function __construct(
        private readonly ArtistCommissionMenuService $service
    ) {
    }

    public function index(Request $request): View
    {
        $artist = Auth::user();
        $errorBag = $request->session()->get('errors');

        $data = $this->service->buildIndexViewData(
            $artist,
            [
                'status' => $request->query('status', 'all'),
                'category_id' => $request->query('category_id'),
                'request_type' => $request->query('request_type', 'all'),
                'search' => $request->query('search', ''),
            ],
            [
                'has_addon_store_errors' => $errorBag instanceof ViewErrorBag && $errorBag->getBag('addonStore')->any(),
                'has_addon_update_errors' => $errorBag instanceof ViewErrorBag && $errorBag->getBag('addonUpdate')->any(),
                'flash_open_menu_id' => $request->session()->get('open_addon_menu_id'),
                'old_input' => $request->session()->getOldInput(),
            ]
        );

        return view('artist.menus.index', $data);
    }

    public function create_menu(Request $request): View
    {
        $categories = $this->service->getCategories();
        $form = $this->service->buildFormViewData(null, $request->session()->getOldInput());

        return view('artist.menus.form_create_menu', compact('categories', 'form'));
    }

    public function store(StoreCommissionMenuRequest $request): RedirectResponse
    {
        $artist = Auth::user();
        $sampleFiles = $request->file('samples', []);
        if (! is_array($sampleFiles)) {
            $sampleFiles = $sampleFiles ? [$sampleFiles] : [];
        }

        try {
            $menu = $this->service->createMenu($artist, $request->validated(), $sampleFiles);
        } catch (\DomainException $e) {
            return back()
                ->withInput()
                ->withErrors(['menu' => $e->getMessage()]);
        }

        return redirect()
            ->route('artist.menus.index')
            ->with('success', 'Paket menu komisi "' . $menu->title . '" berhasil ditambahkan.');
    }

    public function edit(Request $request, CommissionMenu $menu): View
    {
        $artist = Auth::user();
        $menu = $this->service->getMenuForEdit($artist, $menu);
        $categories = $this->service->getCategories();
        $form = $this->service->buildFormViewData($menu, $request->session()->getOldInput());

        return view('artist.menus.edit', compact('menu', 'categories', 'form'));
    }

    public function update(UpdateCommissionMenuRequest $request, CommissionMenu $menu): RedirectResponse
    {
        $artist = Auth::user();
        $validated = $request->validated();
        $sampleFiles = $request->file('samples', []);
        if (! is_array($sampleFiles)) {
            $sampleFiles = $sampleFiles ? [$sampleFiles] : [];
        }
        $removeSampleIds = $validated['remove_sample_ids'] ?? [];

        try {
            $updated = $this->service->updateMenu($artist, $menu, $validated, $sampleFiles, $removeSampleIds);
        } catch (\DomainException $e) {
            return back()
                ->withInput()
                ->withErrors(['menu' => $e->getMessage()]);
        }

        return redirect()
            ->route('artist.menus.index')
            ->with('success', 'Perubahan pada paket "' . $updated->title . '" berhasil disimpan.');
    }

    public function toggle(CommissionMenu $menu): RedirectResponse
    {
        $artist = Auth::user();
        $updated = $this->service->toggleActive($artist, $menu);

        if ($updated->is_active) {
            $message = $updated->available_slots === 0
                ? 'Paket "' . $updated->title . '" berhasil diaktifkan kembali. Tambahkan jumlah slot di menu Edit agar client dapat memesan.'
                : 'Paket "' . $updated->title . '" berhasil diaktifkan dan tampil di katalog publik.';
        } else {
            $message = 'Slot paket "' . $updated->title . '" berhasil ditutup sementara dari katalog publik.';
        }

        return $this->redirectToMenusIndex()
            ->with('success', $message);
    }

    public function destroy(CommissionMenu $menu): RedirectResponse
    {
        $artist = Auth::user();
        $title = $menu->title;

        try {
            $this->service->deleteMenu($artist, $menu);
        } catch (\DomainException $e) {
            return redirect()
                ->route('artist.menus.index')
                ->withErrors(['menu' => $e->getMessage()]);
        }

        return redirect()
            ->route('artist.menus.index')
            ->with('success', 'Paket menu komisi "' . $title . '" berhasil dihapus.');
    }

    public function storeAddon(StoreCommissionAddonRequest $request, CommissionMenu $menu): RedirectResponse
    {
        $artist = Auth::user();

        try {
            $addon = $this->service->storeAddon($artist, $menu, $request->validated());
        } catch (\DomainException $e) {
            return $this->redirectToMenusIndex()
                ->withInput()
                ->with('open_addon_menu_id', $menu->id)
                ->withErrors(['addon' => $e->getMessage()], 'addonStore');
        }

        return $this->redirectToMenusIndex()
            ->with('open_addon_menu_id', $menu->id)
            ->with('addon_success', 'Add-on "' . $addon->title . '" berhasil ditambahkan ke paket "' . $menu->title . '".')
            ->with('success', 'Add-on "' . $addon->title . '" berhasil ditambahkan.');
    }

    public function updateAddon(UpdateCommissionAddonRequest $request, CommissionMenu $menu, CommissionAddon $addon): RedirectResponse
    {
        $artist = Auth::user();
        $updated = $this->service->updateAddon($artist, $menu, $addon, $request->validated());

        return $this->redirectToMenusIndex()
            ->with('open_addon_menu_id', $menu->id)
            ->with('addon_success', 'Add-on "' . $updated->title . '" berhasil diperbarui.')
            ->with('success', 'Add-on "' . $updated->title . '" berhasil diperbarui.');
    }

    public function destroyAddon(CommissionMenu $menu, CommissionAddon $addon): RedirectResponse
    {
        $artist = Auth::user();
        $title = $addon->title;
        $this->service->deleteAddon($artist, $menu, $addon);

        return $this->redirectToMenusIndex()
            ->with('open_addon_menu_id', $menu->id)
            ->with('addon_success', 'Add-on "' . $title . '" berhasil dihapus dari paket.')
            ->with('success', 'Add-on "' . $title . '" berhasil dihapus.');
    }

    public function destroySample(CommissionMenu $menu, CommissionSample $sample): RedirectResponse
    {
        $artist = Auth::user();
        $this->service->deleteSample($artist, $menu, $sample);

        return redirect()
            ->route('artist.menus.edit', $menu)
            ->with('success', 'Sampel gambar berhasil dihapus.');
    }

    public function showSample(int $artistId, string $filename): StreamedResponse
    {
        return $this->service->servePublicSample($artistId, $filename);
    }

    private function redirectToMenusIndex(): RedirectResponse
    {
        $previous = url()->previous();
        $indexUrl = route('artist.menus.index');

        $prevParts = parse_url($previous);
        $indexParts = parse_url($indexUrl);

        if (
            is_array($prevParts)
            && is_array($indexParts)
            && ($prevParts['scheme'] ?? null) === ($indexParts['scheme'] ?? null)
            && ($prevParts['host'] ?? null) === ($indexParts['host'] ?? null)
            && ($prevParts['port'] ?? null) === ($indexParts['port'] ?? null)
            && ($prevParts['path'] ?? null) === ($indexParts['path'] ?? null)
        ) {
            return redirect()->to($previous);
        }

        return redirect()->route('artist.menus.index');
    }
}
