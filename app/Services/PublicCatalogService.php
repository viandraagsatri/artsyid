<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CommissionMenu;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class PublicCatalogService
{
    private const AVG_RATING_SUBQUERY = '(SELECT AVG(r.rating) FROM reviews r INNER JOIN orders o ON o.id = r.order_id WHERE o.commission_menu_id = commission_menus.id)';

    public function getLandingPageData(array $rawFilters = []): array
    {
        $activeCategory = $this->scalarParam($rawFilters, 'category');
        $rawSort = $this->scalarParam($rawFilters, 'sort', 'relevant');
        $activeSort = in_array($rawSort, ['relevant', 'rating', 'price_asc', 'newest'], true)
            ? $rawSort
            : 'relevant';

        $sortOptions = [
            ['value' => 'relevant', 'label' => 'Paling Relevan', 'selected' => $activeSort === 'relevant'],
            ['value' => 'rating', 'label' => 'Rating Tertinggi', 'selected' => $activeSort === 'rating'],
            ['value' => 'price_asc', 'label' => 'Harga: Terendah ke Tertinggi', 'selected' => $activeSort === 'price_asc'],
            ['value' => 'newest', 'label' => 'Slot Terbaru', 'selected' => $activeSort === 'newest'],
        ];

        if (! Schema::hasTable('categories') || ! Schema::hasTable('commission_menus')) {
            $categories = [[
                'slug' => '',
                'name' => 'Semua Kategori',
                'active' => true,
                'home_url' => route('home') . '#katalog',
                'katalog_url' => route('katalog'),
            ]];
            $popularCategories = [];
            $menuCards = [];
            $activeCategory = '';
            $totalPublicMenus = 0;

            return compact(
                'categories',
                'popularCategories',
                'menuCards',
                'activeCategory',
                'activeSort',
                'sortOptions',
                'totalPublicMenus'
            );
        }

        $dbCategories = Category::query()
            ->orderBy('id')
            ->get(['id', 'name', 'slug']);

        $validSlugs = $dbCategories->pluck('slug')->all();
        if ($activeCategory !== '' && ! in_array($activeCategory, $validSlugs, true)) {
            $activeCategory = '';
        }

        $categories = [
            [
                'slug' => '',
                'name' => 'Semua Kategori',
                'active' => $activeCategory === '',
                'home_url' => route('home', array_filter(['sort' => $activeSort !== 'relevant' ? $activeSort : null])) . '#katalog',
                'katalog_url' => route('katalog'),
            ],
        ];

        foreach ($dbCategories as $cat) {
            $categories[] = [
                'slug' => $cat->slug,
                'name' => $cat->name,
                'active' => $activeCategory === $cat->slug,
                'home_url' => route('home', array_filter([
                    'category' => $cat->slug,
                    'sort' => $activeSort !== 'relevant' ? $activeSort : null,
                ])) . '#katalog',
                'katalog_url' => route('katalog', ['category' => $cat->slug]),
            ];
        }

        $popularCategories = $dbCategories
            ->take(4)
            ->map(fn (Category $cat) => [
                'slug' => $cat->slug,
                'name' => $cat->name,
                'katalog_url' => route('katalog', ['category' => $cat->slug]),
            ])
            ->values()
            ->all();

        $query = $this->publicBaseQuery();
        if ($activeCategory !== '') {
            $query->whereHas('category', fn (Builder $q) => $q->where('slug', $activeCategory));
        }
        $this->applySorting($query, $activeSort);

        $menuCards = $query
            ->take(8)
            ->get()
            ->map(fn (CommissionMenu $menu) => $this->formatCatalogCard($menu))
            ->values()
            ->all();

        $totalPublicMenus = CommissionMenu::query()
            ->where('is_active', true)
            ->whereHas('artist', fn (Builder $q) => $q->where('role', 'artist')->where('is_blocked', false))
            ->count();

        return compact(
            'categories',
            'popularCategories',
            'menuCards',
            'activeCategory',
            'activeSort',
            'sortOptions',
            'totalPublicMenus'
        );
    }

    public function getCatalogPageData(array $rawFilters = []): array
    {
        $search = trim($this->scalarParam($rawFilters, 'search'));
        $activeCategory = $this->scalarParam($rawFilters, 'category');
        $openSlotOnly = $this->scalarParam($rawFilters, 'open_slot') === '1';

        $rawPriceRange = $this->scalarParam($rawFilters, 'price_range', 'all');
        $priceRange = in_array($rawPriceRange, ['all', 'under_300', '300_700', 'above_700'], true)
            ? $rawPriceRange
            : 'all';

        $rawDurations = $rawFilters['duration'] ?? [];
        $durations = is_array($rawDurations)
            ? array_values(array_unique(array_filter(
                array_map(fn ($v) => is_scalar($v) ? (string) $v : '', $rawDurations),
                fn (string $v) => in_array($v, ['fast', 'standard', 'large'], true)
            )))
            : [];

        $rawRating = $this->scalarParam($rawFilters, 'rating', 'all');
        $rating = in_array($rawRating, ['all', '5', '4_8'], true)
            ? $rawRating
            : 'all';

        $rawSort = $this->scalarParam($rawFilters, 'sort', 'relevant');
        $sort = in_array($rawSort, ['relevant', 'rating', 'price_asc', 'price_desc', 'newest'], true)
            ? $rawSort
            : 'relevant';

        $sortOptions = [
            ['value' => 'relevant', 'label' => 'Paling Relevan', 'selected' => $sort === 'relevant'],
            ['value' => 'rating', 'label' => 'Rating Tertinggi', 'selected' => $sort === 'rating'],
            ['value' => 'price_asc', 'label' => 'Harga: Terendah ke Tertinggi', 'selected' => $sort === 'price_asc'],
            ['value' => 'price_desc', 'label' => 'Harga: Tertinggi ke Terendah', 'selected' => $sort === 'price_desc'],
            ['value' => 'newest', 'label' => 'Terbaru', 'selected' => $sort === 'newest'],
        ];

        if (! Schema::hasTable('categories') || ! Schema::hasTable('commission_menus')) {
            $menus = new LengthAwarePaginator([], 0, 9);
            $menuCards = [];
            $categories = [[
                'slug' => '',
                'name' => 'Semua Kategori',
                'active' => true,
                'url' => route('katalog'),
            ]];
            $filters = [
                'search' => $search,
                'category' => '',
                'open_slot' => $openSlotOnly,
                'price_range' => $priceRange,
                'durations' => $durations,
                'rating' => $rating,
                'sort' => $sort,
            ];
            $hasActiveFilters = false;
            $pagination = [
                'showing_count' => 0,
                'total' => 0,
                'current_page' => 1,
                'last_page' => 1,
                'has_pages' => false,
                'prev_url' => null,
                'next_url' => null,
                'pages' => [['type' => 'page', 'number' => 1, 'url' => route('katalog'), 'active' => true]],
            ];

            return compact('menus', 'menuCards', 'categories', 'filters', 'hasActiveFilters', 'sortOptions', 'pagination');
        }

        $dbCategories = Category::query()
            ->orderBy('id')
            ->get(['id', 'name', 'slug']);

        $validSlugs = $dbCategories->pluck('slug')->all();
        if ($activeCategory !== '' && ! in_array($activeCategory, $validSlugs, true)) {
            $activeCategory = '';
        }

        $baseFilterParams = array_filter([
            'search' => $search !== '' ? $search : null,
            'open_slot' => $openSlotOnly ? '1' : null,
            'price_range' => $priceRange !== 'all' ? $priceRange : null,
            'duration' => $durations !== [] ? $durations : null,
            'rating' => $rating !== 'all' ? $rating : null,
            'sort' => $sort !== 'relevant' ? $sort : null,
        ], fn ($v) => $v !== null);

        $categories = [
            [
                'slug' => '',
                'name' => 'Semua Kategori',
                'active' => $activeCategory === '',
                'url' => route('katalog', $baseFilterParams),
            ],
        ];

        foreach ($dbCategories as $cat) {
            $categories[] = [
                'slug' => $cat->slug,
                'name' => $cat->name,
                'active' => $activeCategory === $cat->slug,
                'url' => route('katalog', array_merge($baseFilterParams, ['category' => $cat->slug])),
            ];
        }

        $query = $this->publicBaseQuery();

        if ($activeCategory !== '') {
            $query->whereHas('category', fn (Builder $q) => $q->where('slug', $activeCategory));
        }

        if ($search !== '') {
            $pattern = '%' . $this->escapeLike(mb_strtolower($search, 'UTF-8')) . '%';
            $query->where(function (Builder $sub) use ($pattern) {
                $sub->whereRaw("LOWER(commission_menus.title) LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereRaw("LOWER(commission_menus.description) LIKE ? ESCAPE '!'", [$pattern])
                    ->orWhereHas('category', fn (Builder $q) => $q->whereRaw("LOWER(name) LIKE ? ESCAPE '!'", [$pattern]))
                    ->orWhereHas('artist', fn (Builder $q) => $q->whereRaw("LOWER(name) LIKE ? ESCAPE '!'", [$pattern]))
                    ->orWhereHas('addons', fn (Builder $q) => $q->whereRaw("LOWER(title) LIKE ? ESCAPE '!'", [$pattern]));
            });
        }

        if ($openSlotOnly) {
            $query->where('commission_menus.available_slots', '>', 0);
        }

        if ($priceRange === 'under_300') {
            $query->where('commission_menus.base_price', '<', 300000);
        } elseif ($priceRange === '300_700') {
            $query->whereBetween('commission_menus.base_price', [300000, 700000]);
        } elseif ($priceRange === 'above_700') {
            $query->where('commission_menus.base_price', '>', 700000);
        }

        if ($durations !== []) {
            $query->where(function (Builder $sub) use ($durations) {
                foreach ($durations as $dur) {
                    if ($dur === 'fast') {
                        $sub->orWhere('commission_menus.estimated_days', '<', 3);
                    } elseif ($dur === 'standard') {
                        $sub->orWhereBetween('commission_menus.estimated_days', [3, 7]);
                    } elseif ($dur === 'large') {
                        $sub->orWhere('commission_menus.estimated_days', '>', 7);
                    }
                }
            });
        }

        if ($rating === '5') {
            $query->whereRaw('COALESCE(' . self::AVG_RATING_SUBQUERY . ', 0) >= 5.0');
        } elseif ($rating === '4_8') {
            $query->whereRaw('COALESCE(' . self::AVG_RATING_SUBQUERY . ', 0) >= 4.8');
        }

        $this->applySorting($query, $sort);

        $menus = $query->paginate(9)->withQueryString();

        $menuCards = collect($menus->items())
            ->map(fn (CommissionMenu $menu) => $this->formatCatalogCard($menu))
            ->values()
            ->all();

        $hasActiveFilters =
            $search !== ''
            || $activeCategory !== ''
            || $openSlotOnly
            || $priceRange !== 'all'
            || $durations !== []
            || $rating !== 'all'
            || $sort !== 'relevant';

        $filters = [
            'search' => $search,
            'category' => $activeCategory,
            'open_slot' => $openSlotOnly,
            'price_range' => $priceRange,
            'durations' => $durations,
            'rating' => $rating,
            'sort' => $sort,
        ];

        $lastPage = max(1, $menus->lastPage());
        $currentPage = $menus->currentPage();
        $pages = $this->buildPaginationItems($menus);

        $pagination = [
            'showing_count' => $menus->count(),
            'total' => $menus->total(),
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'has_pages' => $menus->hasPages(),
            'prev_url' => $menus->previousPageUrl(),
            'next_url' => $menus->nextPageUrl(),
            'pages' => $pages,
        ];

        return compact(
            'menus',
            'menuCards',
            'categories',
            'filters',
            'hasActiveFilters',
            'sortOptions',
            'pagination'
        );
    }

    public function getCatalogDetailData(int $menuId, ?User $viewer = null): array
    {
        $menu = CommissionMenu::query()
            ->whereKey($menuId)
            ->where('is_active', true)
            ->whereHas('artist', fn (Builder $q) => $q->where('role', 'artist')->where('is_blocked', false))
            ->with([
                'category:id,name,slug',
                'artist:id,name,bio,avatar_url,role,is_blocked',
                'artist.artistProfile:id,user_id,tos',
                'samples' => fn ($q) => $q->orderBy('id'),
                'addons' => fn ($q) => $q->orderBy('id'),
            ])
            ->withCount([
                'reviews',
                'orders as completed_orders_count' => fn (Builder $q) => $q->where('status', 'completed'),
            ])
            ->withAvg('reviews', 'rating')
            ->firstOrFail();

        $menuReviews = $menu->reviews()
            ->with('client:id,name,avatar_url')
            ->orderByDesc('reviews.created_at')
            ->limit(20)
            ->get();

        $artistCompletedOrders = Order::query()
            ->where('artist_id', $menu->artist_id)
            ->where('status', 'completed')
            ->count();

        $samples = $menu->samples
            ->map(function ($sample) {
                $safeUrl = ArtistCommissionMenuService::resolveSafeImageUrl($sample->image_url);

                return $safeUrl ? [
                    'id' => $sample->id,
                    'url' => $safeUrl,
                ] : null;
            })
            ->filter()
            ->values()
            ->map(fn (array $sample, int $index) => [
                'id' => $sample['id'],
                'url' => $sample['url'],
                'alt' => 'Sampel karya #' . ($index + 1),
                'is_first' => $index === 0,
            ])
            ->all();

        $addons = $menu->addons
            ->map(fn ($addon) => [
                'id' => $addon->id,
                'title' => $addon->title,
                'description' => $addon->description ?? '',
                'price' => (int) round((float) $addon->price),
            ])
            ->values()
            ->all();

        $rawTos = $menu->artist?->artistProfile?->tos;
        $tos = [
            'can_draw' => $this->normalizeTosList($rawTos['bisa_digambar'] ?? []),
            'cannot_draw' => $this->normalizeTosList($rawTos['tidak_menerima'] ?? []),
        ];

        $reviews = $menuReviews
            ->map(function (Review $review) {
                $clientName = $review->client?->name ?? 'Client Artsy';

                return [
                    'client_name' => $clientName,
                    'client_initial' => mb_strtoupper(mb_substr($clientName, 0, 1, 'UTF-8'), 'UTF-8'),
                    'client_avatar_url' => ArtistCommissionMenuService::resolveSafeImageUrl($review->client?->avatar_url),
                    'rating' => max(1, min(5, (int) $review->rating)),
                    'comment' => $review->comment ?? '',
                    'tip_amount' => (int) round((float) ($review->tip_amount ?? 0)),
                    'created_at_label' => $review->created_at
                        ? $review->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y')
                        : '-',
                ];
            })
            ->values()
            ->all();

        $basePrice = (int) round((float) $menu->base_price);
        $dpPercentage = (int) round((float) $menu->dp_percentage);
        $initialDpAmount = (int) round(($basePrice * $dpPercentage) / 100);
        $reviewsCount = (int) $menu->reviews_count;
        $avgRatingFloat = ($reviewsCount > 0 && $menu->reviews_avg_rating !== null)
            ? (float) $menu->reviews_avg_rating
            : null;
        $artistName = $menu->artist?->name ?? 'Artist Artsy';

        $detail = [
            'id' => $menu->id,
            'title' => $menu->title,
            'description' => $menu->description,
            'category_name' => $menu->category?->name ?? 'Umum',
            'category_slug' => $menu->category?->slug ?? '',
            'category_url' => $menu->category?->slug
                ? route('katalog', ['category' => $menu->category->slug])
                : route('katalog'),
            'request_type' => $menu->request_type,
            'request_type_label' => $menu->request_type === 'instant' ? 'Order Instant' : 'Custom Request',
            'estimated_days' => (int) $menu->estimated_days,
            'max_revision' => (int) $menu->max_revision,
            'available_slots' => (int) $menu->available_slots,
            'is_open_slot' => (int) $menu->available_slots > 0,
            'base_price' => $basePrice,
            'dp_percentage' => $dpPercentage,
            'initial_dp_amount' => $initialDpAmount,
            'reviews_count' => $reviewsCount,
            'reviews_shown_count' => count($reviews),
            'has_more_reviews' => $reviewsCount > count($reviews),
            'avg_rating_formatted' => $avgRatingFloat !== null
                ? number_format($avgRatingFloat, 1)
                : null,
            'avg_rating_stars' => $this->buildRatingStars($avgRatingFloat),
            'completed_orders_count' => (int) $menu->completed_orders_count,
            'artist_name' => $artistName,
            'artist_initial' => mb_strtoupper(mb_substr($artistName, 0, 1, 'UTF-8'), 'UTF-8'),
            'artist_avatar_url' => ArtistCommissionMenuService::resolveSafeImageUrl($menu->artist?->avatar_url),
            'artist_bio' => $menu->artist?->bio ?? 'Kreator seni digital terverifikasi di platform Artsy ID.',
            'artist_completed_orders' => $artistCompletedOrders,
        ];

        $cta = $this->resolveDetailCta($menu, $viewer);
        $calculatorConfig = [
            'basePrice' => $basePrice,
            'dpPercentage' => $dpPercentage,
        ];

        return compact('detail', 'samples', 'addons', 'tos', 'reviews', 'cta', 'calculatorConfig');
    }

    private function resolveDetailCta(CommissionMenu $menu, ?User $viewer): array
    {
        if ((int) $menu->available_slots <= 0) {
            return [
                'mode' => 'disabled',
                'label' => 'Slot Sedang Penuh',
                'hint' => 'Slot paket ini sedang penuh. Silakan cek kembali nanti atau pilih paket lain.',
                'url' => null,
            ];
        }

        if ($viewer === null) {
            return [
                'mode' => 'link',
                'label' => 'Masuk untuk Memesan',
                'hint' => 'Masuk ke akun Client Anda terlebih dahulu untuk melanjutkan pemesanan komisi.',
                'url' => route('login'),
            ];
        }

        if ($viewer->role === 'user') {
            return [
                'mode' => 'link',
                'label' => 'Lanjut Memesan',
                'hint' => 'Bebas pembatalan sebelum draf sketsa pertama dikerjakan.',
                'url' => route('user.orders.index'),
            ];
        }

        $roleLabel = $viewer->role === 'admin' ? 'Admin' : 'Artist';

        return [
            'mode' => 'disabled',
            'label' => 'Khusus Akun Client',
            'hint' => 'Anda sedang masuk sebagai ' . $roleLabel . '. Pemesanan komisi hanya tersedia untuk akun Client.',
            'url' => null,
        ];
    }

    private function publicBaseQuery(): Builder
    {
        return CommissionMenu::query()
            ->where('commission_menus.is_active', true)
            ->whereHas('artist', fn (Builder $q) => $q->where('role', 'artist')->where('is_blocked', false))
            ->with([
                'category:id,name,slug',
                'artist:id,name,avatar_url',
                'samples' => fn ($q) => $q->orderBy('id'),
            ])
            ->withCount([
                'reviews',
                'orders as completed_orders_count' => fn (Builder $q) => $q->where('status', 'completed'),
            ])
            ->withAvg('reviews', 'rating');
    }

    private function applySorting(Builder $query, string $sort): void
    {
        if ($sort === 'rating') {
            $query->orderByRaw('COALESCE(' . self::AVG_RATING_SUBQUERY . ', 0) DESC')
                ->orderByDesc('reviews_count')
                ->orderByDesc('commission_menus.id');

            return;
        }

        if ($sort === 'price_asc') {
            $query->orderBy('commission_menus.base_price', 'asc')
                ->orderByDesc('commission_menus.id');

            return;
        }

        if ($sort === 'price_desc') {
            $query->orderBy('commission_menus.base_price', 'desc')
                ->orderByDesc('commission_menus.id');

            return;
        }

        if ($sort === 'newest') {
            $query->orderByDesc('commission_menus.created_at')
                ->orderByDesc('commission_menus.id');

            return;
        }

        $query->orderByRaw('CASE WHEN commission_menus.available_slots > 0 THEN 0 ELSE 1 END ASC')
            ->orderByRaw('COALESCE(' . self::AVG_RATING_SUBQUERY . ', 0) DESC')
            ->orderByDesc('reviews_count')
            ->orderByDesc('commission_menus.id');
    }

    private function formatCatalogCard(CommissionMenu $menu): array
    {
        $basePrice = (int) round((float) $menu->base_price);
        $dpPercentage = (int) round((float) $menu->dp_percentage);
        $dpAmount = (int) round(($basePrice * $dpPercentage) / 100);
        $thumbnailUrl = $menu->samples
            ->map(fn ($sample) => ArtistCommissionMenuService::resolveSafeImageUrl($sample->image_url))
            ->filter()
            ->first();
        $artistName = $menu->artist?->name ?? 'Artist Artsy';
        $reviewsCount = (int) $menu->reviews_count;

        return [
            'id' => $menu->id,
            'detail_url' => route('katalog.detail', ['id' => $menu->id]),
            'title' => $menu->title,
            'category_name' => $menu->category?->name ?? 'Umum',
            'estimated_days' => (int) $menu->estimated_days,
            'available_slots' => (int) $menu->available_slots,
            'is_open_slot' => (int) $menu->available_slots > 0,
            'base_price' => $basePrice,
            'dp_percentage' => $dpPercentage,
            'dp_amount' => $dpAmount,
            'dp_short_label' => 'DP ' . $this->formatShortRupiah($dpAmount),
            'thumbnail_url' => $thumbnailUrl,
            'artist_name' => $artistName,
            'artist_initial' => mb_strtoupper(mb_substr($artistName, 0, 1, 'UTF-8'), 'UTF-8'),
            'artist_avatar_url' => ArtistCommissionMenuService::resolveSafeImageUrl($menu->artist?->avatar_url),
            'reviews_count' => $reviewsCount,
            'avg_rating_formatted' => ($reviewsCount > 0 && $menu->reviews_avg_rating !== null)
                ? number_format((float) $menu->reviews_avg_rating, 1)
                : null,
            'completed_orders_count' => (int) $menu->completed_orders_count,
        ];
    }

    private function formatShortRupiah(int $amount): string
    {
        if ($amount >= 10000 && $amount % 1000 === 0) {
            return 'Rp ' . number_format((int) ($amount / 1000), 0, ',', '.') . 'rb';
        }

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    private function normalizeTosList(mixed $items): array
    {
        if (! is_array($items)) {
            return [];
        }

        return array_values(array_filter(
            array_map(fn ($item) => is_scalar($item) ? trim((string) $item) : '', $items),
            fn (string $text) => $text !== ''
        ));
    }

    private function scalarParam(array $params, string $key, string $default = ''): string
    {
        if (! array_key_exists($key, $params) || ! is_scalar($params[$key])) {
            return $default;
        }

        return trim((string) $params[$key]);
    }

    private function buildPaginationItems(LengthAwarePaginator $menus): array
    {
        $lastPage = max(1, $menus->lastPage());
        $currentPage = $menus->currentPage();

        $numbers = [1, $lastPage];
        for ($page = max(1, $currentPage - 2); $page <= min($lastPage, $currentPage + 2); $page++) {
            $numbers[] = $page;
        }
        $numbers = array_values(array_unique($numbers));
        sort($numbers);

        $pages = [];
        $previous = null;

        foreach ($numbers as $page) {
            if ($previous !== null && $page - $previous === 2) {
                $gapPage = $previous + 1;
                $pages[] = [
                    'type' => 'page',
                    'number' => $gapPage,
                    'url' => $menus->url($gapPage),
                    'active' => $gapPage === $currentPage,
                ];
            } elseif ($previous !== null && $page - $previous > 2) {
                $pages[] = [
                    'type' => 'ellipsis',
                    'number' => null,
                    'url' => null,
                    'active' => false,
                ];
            }

            $pages[] = [
                'type' => 'page',
                'number' => $page,
                'url' => $menus->url($page),
                'active' => $page === $currentPage,
            ];

            $previous = $page;
        }

        return $pages;
    }

    private function buildRatingStars(?float $avgRating): array
    {
        $stars = [];

        for ($i = 1; $i <= 5; $i++) {
            if ($avgRating === null) {
                $stars[] = 'empty';
            } elseif ($avgRating >= $i - 0.25) {
                $stars[] = 'full';
            } elseif ($avgRating >= $i - 0.75) {
                $stars[] = 'half';
            } else {
                $stars[] = 'empty';
            }
        }

        return $stars;
    }

    private function escapeLike(string $value): string
    {
        return str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $value);
    }
}
