<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;
use App\Services\ArtistDashboardService;
use App\Services\UserDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(
        Request $request,
        UserDashboardService $userService,
        ArtistDashboardService $artistService,
        AdminDashboardService $adminService
    ) {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'user') {
            $data = $userService->getDashboardData($user);
            return view('user.dashboard', $data);
        } elseif ($role === 'artist') {
            $data = $artistService->getDashboardData($user);
            return view('artist.dashboard', $data);
        } elseif ($role === 'admin') {
            $data = $adminService->getDashboardData();
            return view('admin.dashboard', $data);
        }

        abort(403);
    }
}
