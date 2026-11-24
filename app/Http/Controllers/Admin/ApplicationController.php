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
        $rawFilter = (string) $request->query('status', 'all');
        $filter = in_array($rawFilter, ArtistApplicationService::ALLOWED_STATUS_FILTERS, true)
            ? $rawFilter
            : 'all';

        $search = trim((string) $request->query('search', ''));
        $searchParam = $search !== '' ? $search : null;

        $applications = $service->getApplicationsForAdmin($filter, $searchParam);
        $stats = $service->getApplicationStats();
        $tabCounts = $service->getStatusCountsForSearch($searchParam);

        return view('admin.applications.index', compact(
            'applications',
            'stats',
            'tabCounts',
            'filter',
            'search',
            'service'
        ));
    }

    public function verify(VerifyArtistApplicationRequest $request, User $user, ArtistApplicationService $service)
    {
        $action = $request->validated('action');
        $adminNotes = $request->validated('admin_notes');

        try {
            if ($action === 'approve') {
                $service->approveApplication($user, $adminNotes);
                return back()->with('success', "Pengajuan artist {$user->name} berhasil disetujui! Akun telah ditingkatkan menjadi Artist.");
            }

            $service->rejectApplication($user, (string) $adminNotes);
            return back()->with('success', "Pengajuan artist {$user->name} telah ditolak.");
        } catch (\DomainException $e) {
            return back()->withErrors(['verification' => $e->getMessage()]);
        }
    }
}
