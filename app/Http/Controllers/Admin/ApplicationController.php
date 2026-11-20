<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VerifyArtistApplicationRequest;
use App\Models\User;
use App\Services\ArtistApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request, ArtistApplicationService $service)
    {
        $filter = $request->query('status', 'all');
        $search = $request->query('search');

        $applications = $service->getApplicationsForAdmin($filter, $search);
        $stats = $service->getApplicationStats();

        return view('admin.applications.index', compact('applications', 'stats', 'filter', 'search', 'service'));
    }

    public function verify(VerifyArtistApplicationRequest $request, User $user, ArtistApplicationService $service)
    {
        $action = $request->validated('action');
        $adminNotes = $request->validated('admin_notes');

        if ($action === 'approve') {
            $service->approveApplication($user, $adminNotes);
            return back()->with('success', "Pengajuan artist {$user->name} berhasil disetujui! Akun telah ditingkatkan menjadi Artist.");
        }

        $service->rejectApplication($user, $adminNotes);
        return back()->with('success', "Pengajuan artist {$user->name} telah ditolak.");
    }
}
