<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request, NotificationService $service)
    {
        $filter = (string) $request->query('filter', 'all');
        if (!in_array($filter, NotificationService::ALLOWED_FILTERS, true)) {
            $filter = 'all';
        }

        $user = Auth::user();
        $notifications = $service->getPaginatedForUser($user, $filter);
        $unreadCount = $service->getUnreadCountForUser($user);
        $totalCount = $service->scopedQueryForUser($user)->count();

        return view('notifications.index', compact(
            'notifications',
            'filter',
            'unreadCount',
            'totalCount',
            'service'
        ));
    }

    public function open(Request $request, Notification $notification, NotificationService $service)
    {
        $service->markAsRead($notification, Auth::user());

        $targetUrl = $service->resolveSafeRedirectUrl($notification->link_url, $request->getHost());

        if ($targetUrl === null) {
            return redirect()->back(fallback: route('dashboard'));
        }

        return redirect()->to($targetUrl);
    }

    public function markAsRead(Request $request, Notification $notification, NotificationService $service)
    {
        $user = Auth::user();
        $service->markAsRead($notification, $user);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'           => true,
                'unread_count' => $service->getUnreadCountForUser($user),
            ]);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead(Request $request, NotificationService $service)
    {
        $user = Auth::user();
        $updated = $service->markAllAsRead($user);

        if ($request->expectsJson()) {
            return response()->json([
                'ok'           => true,
                'updated'      => $updated,
                'unread_count' => 0,
            ]);
        }

        $message = $updated > 0
            ? "{$updated} notifikasi ditandai sudah dibaca."
            : 'Semua notifikasi sudah dibaca.';

        return back()->with('success', $message);
    }
}
