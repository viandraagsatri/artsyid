<?php

namespace App\Services;

use App\Models\ArtistReport;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class NotificationService
{
    public const ALLOWED_FILTERS = ['all', 'unread'];

    private const FORBIDDEN_PREFIXES_BY_ROLE = [
        'admin'  => ['/artist', '/user', '/register/artist', '/profile/katalog', '/profile/portofolio'],
        'artist' => ['/admin', '/user', '/register/artist'],
        'user'   => ['/admin', '/artist', '/profile/katalog', '/profile/portofolio'],
    ];

    public function scopedQueryForUser(User $user): Builder
    {
        $query = Notification::query()->where('user_id', $user->id);
        $forbiddenPrefixes = self::FORBIDDEN_PREFIXES_BY_ROLE[$user->role] ?? self::FORBIDDEN_PREFIXES_BY_ROLE['user'];
        $allowRegisterArtist = !in_array('/register/artist', $forbiddenPrefixes, true);

        foreach ($forbiddenPrefixes as $prefix) {
            $query->where(function (Builder $q) use ($prefix, $allowRegisterArtist) {
                $applyForbidden = function (Builder $sub) use ($prefix): void {
                    $sub->whereRaw("LOWER(COALESCE(link_url, '')) NOT LIKE ?", ['%' . $prefix])
                        ->whereRaw("LOWER(COALESCE(link_url, '')) NOT LIKE ?", ['%' . $prefix . '/%'])
                        ->whereRaw("LOWER(COALESCE(link_url, '')) NOT LIKE ?", ['%' . $prefix . '?%'])
                        ->whereRaw("LOWER(COALESCE(link_url, '')) NOT LIKE ?", ['%' . $prefix . '#%']);
                };

                if ($allowRegisterArtist && $prefix === '/artist') {
                    $q->whereRaw("LOWER(COALESCE(link_url, '')) LIKE '/register/artist%'")
                        ->orWhereRaw("LOWER(COALESCE(link_url, '')) LIKE '%/register/artist'")
                        ->orWhereRaw("LOWER(COALESCE(link_url, '')) LIKE '%/register/artist?%'")
                        ->orWhereRaw("LOWER(COALESCE(link_url, '')) LIKE '%/register/artist#%'")
                        ->orWhere($applyForbidden);
                } else {
                    $applyForbidden($q);
                }
            });
        }

        return $query;
    }

    public function isAccessibleToUser(Notification $notification, User $user): bool
    {
        if ((int) $notification->user_id !== (int) $user->id) {
            return false;
        }

        $linkUrl = trim((string) $notification->link_url);
        if ($linkUrl === '') {
            return true;
        }

        $path = strtolower((string) parse_url($linkUrl, PHP_URL_PATH));
        if ($path === '') {
            return true;
        }

        $forbiddenPrefixes = self::FORBIDDEN_PREFIXES_BY_ROLE[$user->role] ?? self::FORBIDDEN_PREFIXES_BY_ROLE['user'];

        foreach ($forbiddenPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return false;
            }
        }

        return true;
    }

    public function resolveSafeRedirectUrl(?string $linkUrl, string $currentHost): ?string
    {
        $trimmed = trim((string) $linkUrl);
        if ($trimmed === '') {
            return null;
        }

        if (preg_match('/^(javascript|data|vbscript):/i', $trimmed)) {
            return route('dashboard', absolute: false);
        }

        if (str_starts_with($trimmed, '/') && !str_starts_with($trimmed, '//')) {
            return $trimmed;
        }

        if (preg_match('#^https?://#i', $trimmed) && filter_var($trimmed, FILTER_VALIDATE_URL) !== false) {
            $parts = parse_url($trimmed);
            $targetHost = strtolower((string) ($parts['host'] ?? ''));
            $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));
            $allowedHosts = array_filter([$appHost, strtolower($currentHost)]);

            if ($targetHost !== '' && in_array($targetHost, $allowedHosts, true)) {
                $path = (string) ($parts['path'] ?? '/');
                if ($path === '' || !str_starts_with($path, '/')) {
                    $path = '/' . $path;
                }
                if (str_starts_with($path, '//')) {
                    return route('dashboard', absolute: false);
                }

                $relative = $path;
                if (isset($parts['query']) && $parts['query'] !== '') {
                    $relative .= '?' . $parts['query'];
                }
                if (isset($parts['fragment']) && $parts['fragment'] !== '') {
                    $relative .= '#' . $parts['fragment'];
                }

                return $relative;
            }
        }

        return route('dashboard', absolute: false);
    }

    public function getUnreadCountForUser(User $user): int
    {
        return $this->scopedQueryForUser($user)
            ->where('is_read', false)
            ->count();
    }

    public function getHeaderNotificationsForUser(User $user, int $limit = 8): EloquentCollection
    {
        return $this->scopedQueryForUser($user)
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function getPaginatedForUser(User $user, string $filter = 'all', int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->scopedQueryForUser($user);

        if ($filter === 'unread') {
            $query->where('is_read', false);
        }

        return $query->latest('id')->paginate($perPage)->withQueryString();
    }

    public function markAsRead(Notification $notification, User $user): Notification
    {
        if (!$this->isAccessibleToUser($notification, $user)) {
            throw new AuthorizationException('Anda tidak berhak mengakses notifikasi ini.');
        }

        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return $notification->fresh();
    }

    public function markAllAsRead(User $user): int
    {
        return $this->scopedQueryForUser($user)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function resolveCategoryMeta(Notification $notification): array
    {
        $haystack = strtolower($notification->title . ' ' . ($notification->link_url ?? ''));

        if (str_contains($haystack, 'artist') && (str_contains($haystack, 'pengajuan') || str_contains($haystack, 'applications'))) {
            return [
                'icon'  => 'fa-id-card-clip',
                'bg'    => 'bg-pastel-100 text-amber-900 border-pastel-300',
                'label' => 'Verifikasi Artist',
            ];
        }

        if (str_contains($haystack, 'payout') || str_contains($haystack, 'pencairan')) {
            return [
                'icon'  => 'fa-money-bill-transfer',
                'bg'    => 'bg-sky-50 text-sky-800 border-sky-200',
                'label' => 'Pencairan Dana',
            ];
        }

        if (str_contains($haystack, 'pembayaran') || preg_match('/\bdp\b/', $haystack) || str_contains($haystack, 'pelunasan') || str_contains($haystack, 'invoice') || str_contains($haystack, 'add-on')) {
            return [
                'icon'  => 'fa-file-invoice-dollar',
                'bg'    => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                'label' => 'Transaksi',
            ];
        }

        if (str_contains($haystack, 'sengketa') || str_contains($haystack, 'laporan') || str_contains($haystack, 'reports')) {
            return [
                'icon'  => 'fa-triangle-exclamation',
                'bg'    => 'bg-red-50 text-red-800 border-red-200',
                'label' => 'Laporan Sengketa',
            ];
        }

        if (str_contains($haystack, 'order') || str_contains($haystack, 'pesanan')) {
            return [
                'icon'  => 'fa-palette',
                'bg'    => 'bg-pastel-100 text-amber-900 border-pastel-300',
                'label' => 'Pesanan',
            ];
        }

        if (str_contains($haystack, 'blokir') || str_contains($haystack, 'role') || str_contains($haystack, 'akun')) {
            return [
                'icon'  => 'fa-shield-halved',
                'bg'    => 'bg-stone-100 text-slate-dark border-stone-200',
                'label' => 'Keamanan Akun',
            ];
        }

        return [
            'icon'  => 'fa-bell',
            'bg'    => 'bg-pastel-100 text-amber-900 border-pastel-300',
            'label' => 'Sistem',
        ];
    }

    public function notifyUser(
        User|int $recipient,
        string $title,
        string $message,
        ?string $linkUrl = null,
        ?string $expectedRole = null
    ): ?Notification {
        $user = $recipient instanceof User ? $recipient : User::find($recipient);

        if (!$user) {
            return null;
        }

        if ($expectedRole !== null && $user->role !== $expectedRole) {
            return null;
        }

        return Notification::create([
            'user_id'  => $user->id,
            'title'    => $title,
            'message'  => $message,
            'link_url' => $linkUrl,
            'is_read'  => false,
        ]);
    }

    public function notifyAdmins(
        string $title,
        string $message,
        ?string $linkUrl = null,
        ?int $excludeUserId = null
    ): int {
        $query = User::query()
            ->where('role', 'admin')
            ->where('is_blocked', false);

        if ($excludeUserId !== null) {
            $query->where('id', '!=', $excludeUserId);
        }

        $admins = $query->get(['id']);

        foreach ($admins as $admin) {
            Notification::create([
                'user_id'  => $admin->id,
                'title'    => $title,
                'message'  => $message,
                'link_url' => $linkUrl,
                'is_read'  => false,
            ]);
        }

        return $admins->count();
    }

    public function notifyNewArtistApplication(User $applicant, bool $isReapplication = false): int
    {
        $title = $isReapplication ? 'Pengajuan Ulang Artist Baru' : 'Pengajuan Artist Baru';
        $message = $isReapplication
            ? "{$applicant->name} ({$applicant->email}) mengajukan ulang pendaftaran menjadi Artist. Silakan tinjau berkas dan portofolio terbarunya."
            : "{$applicant->name} ({$applicant->email}) mendaftar menjadi Artist dan menunggu verifikasi admin.";

        return $this->notifyAdmins(
            $title,
            $message,
            route('admin.applications.index', [
                'status' => 'pending',
                'search' => $applicant->email,
            ]),
            $applicant->id
        );
    }

    public function notifyNewOrder(Order $order): void
    {
        if ($order->request_type === 'instant') {
            $this->notifyUser(
                $order->artist_id,
                'Pesanan Instant Baru Masuk',
                "Pesanan instant #{$order->order_number} dibuat oleh Client dan sedang menunggu pembayaran DP.",
                route('artist.orders.index'),
                'artist'
            );

            $this->notifyUser(
                $order->client_id,
                'Pesanan Instant Diterima',
                "Pesanan #{$order->order_number} otomatis diterima. Silakan selesaikan pembayaran DP 50% agar pengerjaan segera dimulai.",
                route('user.invoices.index'),
                'user'
            );

            return;
        }

        $this->notifyUser(
            $order->artist_id,
            'Request Komisi Baru Masuk',
            "Client mengajukan permintaan komisi baru (#{$order->order_number}). Silakan tinjau dan konfirmasi pesanan.",
            route('artist.orders.index'),
            'artist'
        );
    }

    public function notifyPayoutQueued(Payout $payout, Order $order): int
    {
        $isLegacyDp = $payout->payout_stage === 'dp';
        $amountLabel = 'Rp ' . number_format((float) $payout->amount, 0, ',', '.');

        return $this->notifyAdmins(
            $isLegacyDp ? 'Antrean Payout DP Siap Diproses' : 'Antrean Payout Komisi Siap Diproses',
            $isLegacyDp
                ? "Pencairan dana DP sebesar {$amountLabel} untuk pesanan #{$order->order_number} siap ditransfer ke rekening Artist."
                : "Pencairan dana komisi penuh sebesar {$amountLabel} untuk pesanan #{$order->order_number} siap ditransfer ke rekening Artist.",
            route('admin.payouts.index')
        );
    }

    public function notifyPayoutProcessed(Payout $payout, Order $order): ?Notification
    {
        $isLegacyDp = $payout->payout_stage === 'dp';
        $amountLabel = 'Rp ' . number_format((float) $payout->amount, 0, ',', '.');

        return $this->notifyUser(
            $payout->artist_id,
            $isLegacyDp ? 'Payout DP Telah Ditransfer' : 'Payout Komisi Telah Ditransfer',
            $isLegacyDp
                ? "Dana DP sebesar {$amountLabel} untuk pesanan #{$order->order_number} telah diproses dan ditransfer oleh admin."
                : "Dana komisi penuh sebesar {$amountLabel} untuk pesanan #{$order->order_number} telah diproses dan ditransfer oleh admin.",
            route('artist.payouts.index'),
            'artist'
        );
    }

    public function notifyNewArtistReport(ArtistReport $report, ?Order $order = null): int
    {
        $orderInfo = $order ? " pada pesanan #{$order->order_number}" : '';

        return $this->notifyAdmins(
            'Laporan Sengketa Baru Masuk',
            "Terdapat laporan baru{$orderInfo} dengan alasan: {$report->reason}. Segera tinjau di menu Laporan Sengketa.",
            route('admin.reports.index')
        );
    }
}
