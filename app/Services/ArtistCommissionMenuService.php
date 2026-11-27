<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CommissionAddon;
use App\Models\CommissionMenu;
use App\Models\CommissionSample;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArtistCommissionMenuService
{
    public const ACTIVE_ORDER_STATUSES = [
        'pending_review',
        'awaiting_dp',
        'on_progress',
        'review',
        'revision',
        'awaiting_final_payment',
    ];

    public const MAX_SAMPLES_PER_MENU = 5;

    public const MAX_ADDONS_PER_MENU = 20;

    public const SAMPLE_STORAGE_PREFIX = '/storage/commission-samples/';

    public function assertMenuOwnership(User $artist, CommissionMenu $menu): void
    {
        abort_unless(
            (int) $menu->artist_id === (int) $artist->id,
            403,
            'Anda tidak memiliki akses ke paket komisi ini.'
        );
    }

    public function assertAddonBelongsToMenu(CommissionMenu $menu, CommissionAddon $addon): void
    {
        abort_unless(
            (int) $addon->commission_menu_id === (int) $menu->id,
            404,
            'Add-on tidak ditemukan pada paket komisi ini.'
        );
    }

    public function assertSampleBelongsToMenu(CommissionMenu $menu, CommissionSample $sample): void
    {
        abort_unless(
            (int) $sample->commission_menu_id === (int) $menu->id,
            404,
            'Sampel gambar tidak ditemukan pada paket komisi ini.'
        );
    }

    public static function resolveSafeImageUrl(?string $url): ?string
    {
        if (! is_string($url)) {
            return null;
        }

        $trimmed = trim($url);
        if ($trimmed === '' || preg_match('/[\x00-\x1F\x7F]/', $trimmed) === 1) {
            return null;
        }

        if (
            str_starts_with($trimmed, '/storage/')
            || str_starts_with($trimmed, 'https://')
            || str_starts_with($trimmed, 'http://')
        ) {
            return $trimmed;
        }

        return null;
    }

    public function servePublicSample(int $artistId, string $filename): StreamedResponse
    {
        if ($artistId <= 0 || str_contains($filename, '..') || str_contains($filename, '/') || str_contains($filename, '\\')) {
            abort(404);
        }

        $relativePath = "commission-samples/{$artistId}/{$filename}";

        if (! Storage::disk('public')->exists($relativePath)) {
            abort(404);
        }

        return Storage::disk('public')->response($relativePath, null, [
            'Cache-Control' => 'public, max-age=604800',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function getCategories(): Collection
    {
        return Category::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    public function calculateDpAmount(float $basePrice, float $dpPercentage): int
    {
        return (int) round(($basePrice * $dpPercentage) / 100);
    }

    public function buildIndexViewData(User $artist, array $filters = [], array $sessionState = []): array
    {
        $data = $this->getMenuListData($artist, $filters);
        $menus = $data['menus'];
        $stats = $data['stats'];
        $normalizedFilters = $data['filters'];

        $hasActiveFilters =
            $normalizedFilters['status'] !== 'all'
            || $normalizedFilters['category_id'] !== null
            || $normalizedFilters['request_type'] !== 'all'
            || $normalizedFilters['search'] !== '';

        $statusDefinitions = [
            'all' => ['label' => 'Semua Paket', 'count' => $stats['total_menus']],
            'active' => ['label' => 'Aktif / Open', 'count' => $stats['active_menus']],
            'inactive' => ['label' => 'Nonaktif / Tutup', 'count' => $stats['inactive_menus']],
        ];

        $statusTabs = [];
        foreach ($statusDefinitions as $tabKey => $tabMeta) {
            $tabParams = array_filter([
                'status' => $tabKey === 'all' ? null : $tabKey,
                'category_id' => $normalizedFilters['category_id'],
                'request_type' => $normalizedFilters['request_type'] !== 'all' ? $normalizedFilters['request_type'] : null,
                'search' => $normalizedFilters['search'] !== '' ? $normalizedFilters['search'] : null,
            ], fn ($val) => $val !== null && $val !== '');

            $statusTabs[] = [
                'key' => $tabKey,
                'label' => $tabMeta['label'],
                'count' => $tabMeta['count'],
                'active' => $normalizedFilters['status'] === $tabKey,
                'url' => route('artist.menus.index', $tabParams),
            ];
        }

        $menuCards = [];
        $addonsPayload = [];
        $menusMetaPayload = [];

        foreach ($menus as $menu) {
            $primarySample = $menu->samples->first();
            $primarySampleUrl = $primarySample
                ? self::resolveSafeImageUrl($primarySample->image_url)
                : null;

            $extraSampleUrls = $menu->samples
                ->slice(1, 3)
                ->map(fn (CommissionSample $sample) => self::resolveSafeImageUrl($sample->image_url))
                ->values()
                ->all();

            if (! $menu->is_active) {
                $slotStatus = 'closed';
                $slotBadgeLabel = 'Slot Ditutup';
                $statusHint = 'Disembunyikan sementara dari katalog publik.';
            } elseif ($menu->available_slots <= 0) {
                $slotStatus = 'full';
                $slotBadgeLabel = 'Slot Penuh (0)';
                $statusHint = 'Tampil di katalog publik namun slot penuh (perbarui slot di menu Edit).';
            } else {
                $slotStatus = 'open';
                $slotBadgeLabel = 'Open Slot';
                $statusHint = 'Tampil di katalog publik dan siap menerima pesanan.';
            }

            $menuCards[] = [
                'model' => $menu,
                'primary_sample_url' => $primarySampleUrl,
                'extra_sample_urls' => $extraSampleUrls,
                'remaining_samples_count' => max(0, $menu->samples->count() - 4),
                'dp_amount' => $this->calculateDpAmount((float) $menu->base_price, (float) $menu->dp_percentage),
                'dp_percentage_int' => (int) $menu->dp_percentage,
                'slot_status' => $slotStatus,
                'slot_badge_label' => $slotBadgeLabel,
                'status_hint' => $statusHint,
                'preview_addons' => $menu->addons->take(4),
                'remaining_addons_count' => max(0, $menu->addons->count() - 4),
            ];

            $addonsPayload[$menu->id] = $menu->addons->map(function (CommissionAddon $addon) use ($menu) {
                return [
                    'id' => $addon->id,
                    'title' => $addon->title,
                    'description' => $addon->description ?? '',
                    'price' => (int) round((float) $addon->price),
                    'updateUrl' => route('artist.menus.addons.update', ['menu' => $menu->id, 'addon' => $addon->id]),
                    'deleteUrl' => route('artist.menus.addons.destroy', ['menu' => $menu->id, 'addon' => $addon->id]),
                ];
            })->values()->all();

            $menusMetaPayload[$menu->id] = [
                'id' => $menu->id,
                'title' => $menu->title,
                'storeAddonUrl' => route('artist.menus.addons.store', ['menu' => $menu->id]),
                'deleteMenuUrl' => route('artist.menus.destroy', ['menu' => $menu->id]),
            ];
        }

        $hasAddonStoreErrors = (bool) ($sessionState['has_addon_store_errors'] ?? false);
        $hasAddonUpdateErrors = (bool) ($sessionState['has_addon_update_errors'] ?? false);
        $hasAddonErrors = $hasAddonStoreErrors || $hasAddonUpdateErrors;
        $oldInput = is_array($sessionState['old_input'] ?? null) ? $sessionState['old_input'] : [];

        $rawOpenMenuId = $sessionState['flash_open_menu_id']
            ?? ($hasAddonErrors ? ($oldInput['addon_menu_id'] ?? null) : null);
        $rawEditAddonId = $hasAddonUpdateErrors ? ($oldInput['addon_edit_id'] ?? null) : null;

        $initialAddonMenuId = is_scalar($rawOpenMenuId) && is_numeric($rawOpenMenuId) ? (int) $rawOpenMenuId : null;
        $initialAddonEditId = is_scalar($rawEditAddonId) && is_numeric($rawEditAddonId) ? (int) $rawEditAddonId : null;

        $initialOldAddonInput = $hasAddonErrors
            ? [
                'title' => $this->scalarValue($oldInput, 'title', ''),
                'price' => $this->scalarValue($oldInput, 'price', ''),
                'description' => $this->scalarValue($oldInput, 'description', ''),
            ]
            : null;

        $modalState = [
            'has_addon_errors' => $hasAddonErrors,
            'has_addon_store_errors' => $hasAddonStoreErrors,
            'has_addon_update_errors' => $hasAddonUpdateErrors,
            'initial_modal_state' => [
                'openMenuId' => $initialAddonMenuId,
                'editAddonId' => $initialAddonEditId,
                'oldInput' => $initialOldAddonInput,
            ],
        ];

        return array_merge($data, compact(
            'hasActiveFilters',
            'statusTabs',
            'menuCards',
            'addonsPayload',
            'menusMetaPayload',
            'modalState'
        ));
    }

    public function buildFormViewData(?CommissionMenu $menu, array $oldInput = []): array
    {
        $isEdit = $menu !== null;
        $rawRemoveIds = is_array($oldInput['remove_sample_ids'] ?? null) ? $oldInput['remove_sample_ids'] : [];
        $oldRemoveIds = collect($rawRemoveIds)
            ->filter(fn ($id) => is_scalar($id) && is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->all();

        $existingSamples = [];
        if ($isEdit) {
            foreach ($menu->samples as $index => $sample) {
                $imageUrl = (string) $sample->image_url;
                $existingSamples[] = [
                    'id' => $sample->id,
                    'number' => $index + 1,
                    'safe_url' => self::resolveSafeImageUrl($imageUrl),
                    'is_local_upload' => str_starts_with($imageUrl, '/storage/'),
                    'is_marked_remove' => in_array((int) $sample->id, $oldRemoveIds, true),
                ];
            }
        }

        $defaultIsActive = $isEdit ? $menu->is_active : true;
        $rawIsActive = array_key_exists('is_active', $oldInput) && is_scalar($oldInput['is_active'])
            ? $oldInput['is_active']
            : $defaultIsActive;

        return [
            'is_edit' => $isEdit,
            'max_samples' => self::MAX_SAMPLES_PER_MENU,
            'title' => $this->scalarValue($oldInput, 'title', $isEdit ? $menu->title : ''),
            'category_id' => $this->scalarValue($oldInput, 'category_id', $isEdit ? $menu->category_id : ''),
            'description' => $this->scalarValue($oldInput, 'description', $isEdit ? $menu->description : ''),
            'base_price' => $this->scalarValue($oldInput, 'base_price', $isEdit ? (int) $menu->base_price : ''),
            'dp_percentage' => $this->scalarValue($oldInput, 'dp_percentage', $isEdit ? (int) $menu->dp_percentage : 50),
            'estimated_days' => $this->scalarValue($oldInput, 'estimated_days', $isEdit ? $menu->estimated_days : 7),
            'max_revision' => $this->scalarValue($oldInput, 'max_revision', $isEdit ? $menu->max_revision : 2),
            'available_slots' => $this->scalarValue($oldInput, 'available_slots', $isEdit ? $menu->available_slots : 3),
            'request_type' => $this->scalarValue($oldInput, 'request_type', $isEdit ? $menu->request_type : 'custom'),
            'is_active' => filter_var($rawIsActive, FILTER_VALIDATE_BOOLEAN),
            'existing_samples' => $existingSamples,
        ];
    }

    public function getMenuListData(User $artist, array $filters = []): array
    {
        $status = in_array($filters['status'] ?? 'all', ['all', 'active', 'inactive'], true)
            ? $filters['status']
            : 'all';

        $requestType = in_array($filters['request_type'] ?? 'all', ['all', 'custom', 'instant'], true)
            ? $filters['request_type']
            : 'all';

        $rawCategoryId = $filters['category_id'] ?? null;
        $categoryId = (is_numeric($rawCategoryId) && (int) $rawCategoryId > 0)
            ? (int) $rawCategoryId
            : null;

        $search = trim((string) ($filters['search'] ?? ''));

        $query = CommissionMenu::query()
            ->where('artist_id', $artist->id)
            ->with([
                'category:id,name,slug',
                'samples' => fn ($q) => $q->orderBy('id'),
                'addons' => fn ($q) => $q->orderBy('id'),
            ])
            ->withCount([
                'orders',
                'addons',
                'samples',
                'orders as active_orders_count' => fn ($q) => $q->whereIn('status', self::ACTIVE_ORDER_STATUSES),
            ]);

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        if ($requestType !== 'all') {
            $query->where('request_type', $requestType);
        }

        if ($search !== '') {
            $pattern = '%' . $this->escapeLike(mb_strtolower($search, 'UTF-8')) . '%';
            $query->where(function ($subQuery) use ($pattern) {
                $subQuery->whereRaw("LOWER(title) LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereRaw("LOWER(description) LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereHas('category', fn ($q) => $q->whereRaw("LOWER(name) LIKE ? ESCAPE '!'", [$pattern]))
                    ->orWhereHas('addons', fn ($q) => $q->whereRaw("LOWER(title) LIKE ? ESCAPE '!'", [$pattern]));
            });
        }

        $menus = $query
            ->orderByDesc('is_active')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $baseArtistMenus = CommissionMenu::query()->where('artist_id', $artist->id);

        $stats = [
            'total_menus' => (clone $baseArtistMenus)->count(),
            'active_menus' => (clone $baseArtistMenus)->where('is_active', true)->count(),
            'inactive_menus' => (clone $baseArtistMenus)->where('is_active', false)->count(),
            'open_slots_total' => (int) (clone $baseArtistMenus)->where('is_active', true)->sum('available_slots'),
            'active_orders_total' => Order::query()
                ->where('artist_id', $artist->id)
                ->whereIn('status', self::ACTIVE_ORDER_STATUSES)
                ->count(),
            'total_addons' => CommissionAddon::query()
                ->whereHas('commissionMenu', fn ($q) => $q->where('artist_id', $artist->id))
                ->count(),
        ];

        return [
            'menus' => $menus,
            'stats' => $stats,
            'categories' => $this->getCategories(),
            'filters' => [
                'status' => $status,
                'category_id' => $categoryId,
                'request_type' => $requestType,
                'search' => $search,
            ],
        ];
    }

    public function getMenuForEdit(User $artist, CommissionMenu $menu): CommissionMenu
    {
        $this->assertMenuOwnership($artist, $menu);

        $menu->load([
            'category:id,name,slug',
            'samples' => fn ($q) => $q->orderBy('id'),
            'addons' => fn ($q) => $q->orderBy('id'),
        ])->loadCount([
            'orders',
            'orders as active_orders_count' => fn ($q) => $q->whereIn('status', self::ACTIVE_ORDER_STATUSES),
        ]);

        return $menu;
    }

    public function createMenu(User $artist, array $data, array $sampleFiles = []): CommissionMenu
    {
        $validFiles = $this->filterUploadedFiles($sampleFiles);

        if (count($validFiles) > self::MAX_SAMPLES_PER_MENU) {
            throw new \DomainException('Maksimal ' . self::MAX_SAMPLES_PER_MENU . ' sampel gambar dapat diunggah per paket komisi.');
        }

        $storedRelativePaths = [];

        try {
            return DB::transaction(function () use ($artist, $data, $validFiles, &$storedRelativePaths): CommissionMenu {
                $menu = CommissionMenu::create([
                    'artist_id' => $artist->id,
                    'category_id' => (int) $data['category_id'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'base_price' => round((float) $data['base_price'], 2),
                    'dp_percentage' => round((float) $data['dp_percentage'], 2),
                    'estimated_days' => (int) $data['estimated_days'],
                    'max_revision' => (int) $data['max_revision'],
                    'available_slots' => (int) $data['available_slots'],
                    'request_type' => $data['request_type'],
                    'is_active' => (bool) ($data['is_active'] ?? true),
                ]);

                foreach ($validFiles as $file) {
                    $path = $file->store("commission-samples/{$artist->id}", 'public');
                    if ($path === false) {
                        throw new \RuntimeException('Gagal menyimpan file sampel gambar ke penyimpanan.');
                    }
                    $storedRelativePaths[] = $path;

                    $menu->samples()->create([
                        'image_url' => '/storage/' . ltrim($path, '/'),
                    ]);
                }

                return $menu->fresh(['category', 'samples', 'addons']);
            });
        } catch (\Throwable $e) {
            $this->cleanupRelativePaths($storedRelativePaths);
            throw $e;
        }
    }

    public function updateMenu(
        User $artist,
        CommissionMenu $menu,
        array $data,
        array $sampleFiles = [],
        array $removeSampleIds = []
    ): CommissionMenu {
        $this->assertMenuOwnership($artist, $menu);

        $validFiles = $this->filterUploadedFiles($sampleFiles);
        $normalizedRemoveIds = array_values(array_unique(array_filter(
            array_map('intval', $removeSampleIds),
            fn (int $id) => $id > 0
        )));

        $storedRelativePaths = [];
        $urlsToDeleteAfterCommit = [];

        try {
            $updated = DB::transaction(function () use (
                $artist,
                $menu,
                $data,
                $validFiles,
                $normalizedRemoveIds,
                &$storedRelativePaths,
                &$urlsToDeleteAfterCommit
            ): CommissionMenu {
                $locked = CommissionMenu::query()
                    ->whereKey($menu->id)
                    ->where('artist_id', $artist->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $removableSamples = $normalizedRemoveIds === []
                    ? collect()
                    : $locked->samples()->whereIn('id', $normalizedRemoveIds)->get();

                $existingCount = $locked->samples()->count();
                $finalSampleCount = ($existingCount - $removableSamples->count()) + count($validFiles);

                if ($finalSampleCount > self::MAX_SAMPLES_PER_MENU) {
                    throw new \DomainException(
                        'Maksimal ' . self::MAX_SAMPLES_PER_MENU . ' sampel gambar per paket komisi. Hapus beberapa sampel lama terlebih dahulu.'
                    );
                }

                $locked->update([
                    'category_id' => (int) $data['category_id'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'base_price' => round((float) $data['base_price'], 2),
                    'dp_percentage' => round((float) $data['dp_percentage'], 2),
                    'estimated_days' => (int) $data['estimated_days'],
                    'max_revision' => (int) $data['max_revision'],
                    'available_slots' => (int) $data['available_slots'],
                    'request_type' => $data['request_type'],
                    'is_active' => (bool) ($data['is_active'] ?? false),
                ]);

                foreach ($removableSamples as $sample) {
                    $urlsToDeleteAfterCommit[] = $sample->image_url;
                    $sample->delete();
                }

                foreach ($validFiles as $file) {
                    $path = $file->store("commission-samples/{$artist->id}", 'public');
                    if ($path === false) {
                        throw new \RuntimeException('Gagal menyimpan file sampel gambar ke penyimpanan.');
                    }
                    $storedRelativePaths[] = $path;

                    $locked->samples()->create([
                        'image_url' => '/storage/' . ltrim($path, '/'),
                    ]);
                }

                return $locked->fresh(['category', 'samples', 'addons']);
            });
        } catch (\Throwable $e) {
            $this->cleanupRelativePaths($storedRelativePaths);
            throw $e;
        }

        foreach ($urlsToDeleteAfterCommit as $url) {
            $this->deleteLocalSampleFile($url);
        }

        return $updated;
    }

    public function toggleActive(User $artist, CommissionMenu $menu): CommissionMenu
    {
        $this->assertMenuOwnership($artist, $menu);

        return DB::transaction(function () use ($artist, $menu): CommissionMenu {
            $locked = CommissionMenu::query()
                ->whereKey($menu->id)
                ->where('artist_id', $artist->id)
                ->lockForUpdate()
                ->firstOrFail();

            $locked->is_active = ! $locked->is_active;
            $locked->save();

            return $locked->fresh();
        });
    }

    public function deleteMenu(User $artist, CommissionMenu $menu): void
    {
        $this->assertMenuOwnership($artist, $menu);

        $sampleUrls = [];

        DB::transaction(function () use ($artist, $menu, &$sampleUrls): void {
            $locked = CommissionMenu::query()
                ->whereKey($menu->id)
                ->where('artist_id', $artist->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->orders()->exists()) {
                throw new \DomainException(
                    'Paket komisi ini sudah memiliki riwayat pesanan sehingga tidak dapat dihapus. Gunakan tombol Tutup Slot untuk menonaktifkannya dari katalog publik.'
                );
            }

            $sampleUrls = $locked->samples()->pluck('image_url')->all();
            $locked->delete();
        });

        foreach ($sampleUrls as $url) {
            $this->deleteLocalSampleFile($url);
        }
    }

    public function storeAddon(User $artist, CommissionMenu $menu, array $data): CommissionAddon
    {
        $this->assertMenuOwnership($artist, $menu);

        return DB::transaction(function () use ($artist, $menu, $data): CommissionAddon {
            $locked = CommissionMenu::query()
                ->whereKey($menu->id)
                ->where('artist_id', $artist->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->addons()->count() >= self::MAX_ADDONS_PER_MENU) {
                throw new \DomainException('Maksimal ' . self::MAX_ADDONS_PER_MENU . ' add-on per paket komisi.');
            }

            return $locked->addons()->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'price' => round((float) $data['price'], 2),
            ]);
        });
    }

    public function updateAddon(User $artist, CommissionMenu $menu, CommissionAddon $addon, array $data): CommissionAddon
    {
        $this->assertMenuOwnership($artist, $menu);
        $this->assertAddonBelongsToMenu($menu, $addon);

        return DB::transaction(function () use ($menu, $addon, $data): CommissionAddon {
            $locked = CommissionAddon::query()
                ->whereKey($addon->id)
                ->where('commission_menu_id', $menu->id)
                ->lockForUpdate()
                ->firstOrFail();

            $locked->update([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'price' => round((float) $data['price'], 2),
            ]);

            return $locked->fresh();
        });
    }

    public function deleteAddon(User $artist, CommissionMenu $menu, CommissionAddon $addon): void
    {
        $this->assertMenuOwnership($artist, $menu);
        $this->assertAddonBelongsToMenu($menu, $addon);

        DB::transaction(function () use ($menu, $addon): void {
            $locked = CommissionAddon::query()
                ->whereKey($addon->id)
                ->where('commission_menu_id', $menu->id)
                ->lockForUpdate()
                ->firstOrFail();

            $locked->delete();
        });
    }

    public function deleteSample(User $artist, CommissionMenu $menu, CommissionSample $sample): void
    {
        $this->assertMenuOwnership($artist, $menu);
        $this->assertSampleBelongsToMenu($menu, $sample);

        $imageUrl = null;

        DB::transaction(function () use ($menu, $sample, &$imageUrl): void {
            $locked = CommissionSample::query()
                ->whereKey($sample->id)
                ->where('commission_menu_id', $menu->id)
                ->lockForUpdate()
                ->firstOrFail();

            $imageUrl = $locked->image_url;
            $locked->delete();
        });

        $this->deleteLocalSampleFile($imageUrl);
    }

    private function filterUploadedFiles(array $files): array
    {
        return array_values(array_filter(
            $files,
            fn ($file) => $file instanceof UploadedFile && $file->isValid()
        ));
    }

    private function cleanupRelativePaths(array $relativePaths): void
    {
        foreach ($relativePaths as $path) {
            if (is_string($path) && $path !== '' && ! str_contains($path, '..')) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    private function deleteLocalSampleFile(?string $imageUrl): void
    {
        if (
            ! is_string($imageUrl)
            || ! str_starts_with($imageUrl, self::SAMPLE_STORAGE_PREFIX)
            || str_contains($imageUrl, '..')
        ) {
            return;
        }

        $relativePath = substr($imageUrl, strlen('/storage/'));
        if ($relativePath !== '') {
            Storage::disk('public')->delete($relativePath);
        }
    }

    private function escapeLike(string $value): string
    {
        return str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $value);
    }

    private function scalarValue(array $input, string $key, mixed $default): string
    {
        if (array_key_exists($key, $input)) {
            if (is_scalar($input[$key])) {
                return (string) $input[$key];
            }

            if ($input[$key] === null) {
                return '';
            }
        }

        return (string) $default;
    }
}
