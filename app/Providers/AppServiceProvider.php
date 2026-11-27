<?php

namespace App\Providers;

use App\Services\NotificationService;
use App\Services\SidebarIndicatorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(
        NotificationService $notificationService,
        SidebarIndicatorService $sidebarIndicatorService
    ): void {
        View::composer('layouts.partials.notification-bell', function ($view) use ($notificationService) {
            $user = Auth::user();

            if (!$user) {
                $view->with([
                    'headerNotifications' => collect(),
                    'headerUnreadCount'   => 0,
                    'notificationService' => $notificationService,
                ]);
                return;
            }

            $view->with([
                'headerNotifications' => $notificationService->getHeaderNotificationsForUser($user, 8),
                'headerUnreadCount'   => $notificationService->getUnreadCountForUser($user),
                'notificationService' => $notificationService,
            ]);
        });

        View::composer('layouts.sidebar', function ($view) use ($sidebarIndicatorService) {
            $view->with(
                'sidebarIndicators',
                $sidebarIndicatorService->getIndicatorsForUser(Auth::user())
            );
        });
    }
}
