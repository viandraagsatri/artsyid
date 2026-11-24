<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArtistApplicationRequest;
use App\Services\ArtistApplicationService;
use Illuminate\Support\Facades\Auth;

class DaftarArtist extends Controller
{
    public function index(ArtistApplicationService $service)
    {
        $user = Auth::user();

        if ($user->role === 'artist') {
            return redirect()->route('dashboard')->with('success', 'Kamu sudah terdaftar sebagai artist.');
        }

        if ($user->role !== 'user') {
            return redirect()->route('dashboard')->with('error', 'Hanya akun Client yang dapat mendaftar menjadi Artist.');
        }

        $hasPending = $service->hasPendingApplication($user->id);
        $lastRejected = $service->getLastRejectedApplication($user->id);
        $previousProfile = $user->artistProfile;
        $history = $service->getApplicationHistory($user->id);
        $previousLinks = $service->getLastRejectedLinks($user->id);

        return view('daftar_artist', compact('hasPending', 'lastRejected', 'previousProfile', 'history', 'previousLinks'));
    }

    public function store(ArtistApplicationRequest $request, ArtistApplicationService $service)
    {
        $user = Auth::user();

        if ($user->role !== 'user') {
            return redirect()->route('dashboard')->with('error', 'Hanya akun Client yang dapat mengajukan pendaftaran menjadi Artist.');
        }

        if ($service->hasPendingApplication($user->id)) {
            return redirect()->route('register.artist');
        }

        $service->storeApplication($user, $request->validated());

        return redirect()->route('register.artist')->with('success', 'Pengajuan terkirim! Admin akan memverifikasi portofolio kamu.');
    }
}
