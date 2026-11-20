<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $role = Auth::user()->role;

        if ($role == 'user') {
            return view('user.profile');
        } elseif ($role == 'admin') {
            return view('admin.profile');
        } elseif ($role == 'artist') {
            return redirect()->route('profile.katalog');
        }

        abort(404);
    }

    public function katalog() 
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        return view('artist.profile.katalog');
    }

    public function portofolio() 
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        return view('artist.profile.portofolio');
    }

    public function settings() 
    {
        return view('artist.profile.setting');
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
