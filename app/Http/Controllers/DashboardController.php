<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;
use App\Services\ArtistDashboardService;
use App\Services\UserDashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'user') {
            $data = app(UserDashboardService::class)->getDashboardData($user);
            return view('user.dashboard', $data);
        } elseif ($role === 'artist') {
            $data = app(ArtistDashboardService::class)->getDashboardData($user);
            return view('artist.dashboard', $data);
        } elseif ($role === 'admin') {
            $data = app(AdminDashboardService::class)->getDashboardData();
            return view('admin.dashboard', $data);
        }

        abort(403);
    }
}
