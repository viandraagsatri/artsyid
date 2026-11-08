<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArtistProfile;
use Illuminate\Http\Request;
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

        return view('404');
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

    public function updateProfile(Request $request)
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->update([
            'name' => $request->name,
        ]);

        ArtistProfile::updateOrCreate(
            ['user_id' => $user->id],
            ['bio' => $request->bio]   
        );

        return redirect()->route('profile.setting')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePw(Request $request)
    {
        if (Auth::user()->role !== 'artist') {
            return redirect()->route('profile');
        }

        $request->validate([
            'current_password' => 'required|current_password', 
            'password' => 'required|confirmed|min:8'
        ], [
            'current_password.current_password' => 'Password lama yang kamu masukkan salah.',
            'password.confirmed' => 'Password baru dan konfirmasi tidak cocok.'
        ]);
        
        $userLogin = Auth::user();
        $user = User::findOrFail($userLogin);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    // public function getPortofolio()
    // {
    //     $portofolios = Portofolio::where('artist_id', Auth::user()->id)->get();
    //     return view('artist.profile.portofolio', compact('portofolios'));
    // }
}
