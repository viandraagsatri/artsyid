<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\AdminUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request, AdminUserService $service)
    {
        $role = $request->query('role', 'all');
        if (!in_array($role, AdminUserService::ALLOWED_ROLES, true)) {
            $role = 'all';
        }

        $status = $request->query('status', 'all');
        if (!in_array($status, AdminUserService::ALLOWED_STATUSES, true)) {
            $status = 'all';
        }

        if ($status === 'reported' && !in_array($role, ['all', 'artist'], true)) {
            $status = 'all';
        }

        $search = trim((string) $request->query('search', ''));

        $users = $service->getUsersForAdmin($role, $status, $search !== '' ? $search : null);
        $stats = $service->getStats();
        $statusCounts = $service->getStatusCountsForRole($role);

        return view('admin.users.index', compact('users', 'stats', 'statusCounts', 'role', 'status', 'search', 'service'));
    }

    public function update(UpdateUserRequest $request, User $user, AdminUserService $service)
    {
        try {
            $updated = $service->updateUser($user, Auth::user(), $request->validated('role'));

            return back()->with('success', "Role pengguna {$updated->name} berhasil diubah menjadi {$updated->role}.");
        } catch (\DomainException $e) {
            return back()->withErrors(['user_action' => $e->getMessage()]);
        }
    }

    public function block(BlockUserRequest $request, User $user, AdminUserService $service)
    {
        try {
            $service->blockUser($user, Auth::user(), $request->validated('block_reason'));

            return back()->with('success', "Akun {$user->name} berhasil diblokir dan sesi aktifnya telah dihentikan.");
        } catch (\DomainException $e) {
            return back()->withErrors(['user_action' => $e->getMessage()]);
        }
    }

    public function unblock(User $user, AdminUserService $service)
    {
        try {
            $service->unblockUser($user, Auth::user());

            return back()->with('success', "Pemblokiran akun {$user->name} berhasil dicabut.");
        } catch (\DomainException $e) {
            return back()->withErrors(['user_action' => $e->getMessage()]);
        }
    }
}
