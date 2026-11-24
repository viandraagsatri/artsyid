<?php

namespace App\Http\Controllers;


use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index() {
        $role = Auth::user()->role;
        $tanggalGabung = Auth::user() -> created_at;
        $tanggalGabungFormated = Carbon::parse($tanggalGabung)->locale('id')->translatedFormat('d F Y');

        if ($role == 'user') {
            return view('user.profile', compact('tanggalGabungFormated'));
        } elseif ($role == 'admin') {
            return view('admin.profile');
        } elseif ($role == 'artist') {
            return redirect()->route('profile.katalog');
        }

        abort(404);
    }

    public function katalog() 
    {
        $tanggalGabung = Auth::user() -> created_at;
        $tanggalGabungFormated = Carbon::parse($tanggalGabung)->locale('id')->translatedFormat('d F Y');
        
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        return view('artist.profile.katalog', compact('tanggalGabungFormated'));
    }

    public function portofolio() 
    {
        $tanggalGabung = Auth::user() -> created_at;
        $tanggalGabungFormated = Carbon::parse($tanggalGabung)->locale('id')->translatedFormat('d F Y');
        
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        return view('artist.profile.portofolio', compact('tanggalGabungFormated'));
    }

    public function settings() 
    {
        $tanggalGabung = Auth::user() -> created_at;
        $tanggalGabungFormated = Carbon::parse($tanggalGabung)->locale('id')->translatedFormat('d F Y');
        
        return view('artist.profile.setting', compact('tanggalGabungFormated'));
    }

    public function updateProfile(UpdateProfileRequest $request, ProfileService $service)
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        $user = User::findOrFail(Auth::id());
        $service->updateProfile($user, $request->validated());

        return redirect()->route('profile.setting')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(UpdatePasswordRequest $request, ProfileService $service)
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        $user = User::findOrFail(Auth::id());
        $service->updatePassword($user, $request->validated('password'));

        return back()->with('success', 'Password berhasil diubah!');
    }
}
