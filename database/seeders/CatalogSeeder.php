<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CommissionAddon;
use App\Models\CommissionMenu;
use App\Models\CommissionSample;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $rara = User::where('email', 'rara@artsy.id')->firstOrFail();
        $viandra = User::where('email', 'viandra@artsy.id')->firstOrFail();

        $categories = [
            'ilustrasi' => Category::updateOrCreate(
                ['slug' => 'ilustrasi-karakter'],
                ['name' => 'Ilustrasi Karakter']
            ),
            'chibi' => Category::updateOrCreate(
                ['slug' => 'avatar-chibi-2d'],
                ['name' => 'Avatar & Chibi 2D']
            ),
            'live2d' => Category::updateOrCreate(
                ['slug' => 'model-live2d-vtuber'],
                ['name' => 'Model Live2D / VTuber']
            ),
            'emote' => Category::updateOrCreate(
                ['slug' => 'emote-badge'],
                ['name' => 'Emote & Badge']
            ),
            'background' => Category::updateOrCreate(
                ['slug' => 'background-concept-art'],
                ['name' => 'Background & Concept Art']
            ),
        ];

        $menuDefs = [
            [
                'artist'          => $rara,
                'category'        => $categories['ilustrasi'],
                'title'           => 'Ilustrasi Half-Body Anime Pastel',
                'description'     => 'Ilustrasi karakter half-body gaya anime pastel dengan pencahayaan lembut dan resolusi tinggi 300 DPI.',
                'base_price'      => 300000,
                'estimated_days'  => 7,
                'max_revision'    => 2,
                'dp_percentage'   => 50,
                'available_slots' => 3,
                'request_type'    => 'custom',
                'sample_url'      => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=Rara+HalfBody+Pastel',
                'addon_title'     => 'Background Detail Interior',
                'addon_desc'      => 'Penambahan latar ruangan bergaya estetis dan pencahayaan ambient.',
                'addon_price'     => 100000,
            ],
            [
                'artist'          => $rara,
                'category'        => $categories['chibi'],
                'title'           => 'Avatar Chibi 2D Ekspresif',
                'description'     => 'Avatar chibi 2D proporsi imut untuk foto profil sosial media, Discord, atau channel streaming.',
                'base_price'      => 250000,
                'estimated_days'  => 5,
                'max_revision'    => 2,
                'dp_percentage'   => 50,
                'available_slots' => 5,
                'request_type'    => 'instant',
                'sample_url'      => 'https://placehold.co/800x600/FFF9C4/1E293B.png?text=Rara+Chibi+2D',
                'addon_title'     => 'Ekspresi Tambahan + Properti',
                'addon_desc'      => 'Variasi 2 ekspresi ekstra beserta aksesori kecil di tangan karakter.',
                'addon_price'     => 50000,
            ],
            [
                'artist'          => $viandra,
                'category'        => $categories['ilustrasi'],
                'title'           => 'Ilustrasi Full-Body Semi-Realis',
                'description'     => 'Ilustrasi karakter full-body dengan rendering semi-realis detail kostum dan efek atmosfer.',
                'base_price'      => 450000,
                'estimated_days'  => 10,
                'max_revision'    => 3,
                'dp_percentage'   => 50,
                'available_slots' => 2,
                'request_type'    => 'custom',
                'sample_url'      => 'https://placehold.co/800x600/FDF1A9/334155.png?text=Viandra+Semi+Realis',
                'addon_title'     => 'Lisensi Commercial Use',
                'addon_desc'      => 'Hak penggunaan komersial penuh untuk merchandise, streaming, dan promosi.',
                'addon_price'     => 150000,
            ],
            [
                'artist'          => $viandra,
                'category'        => $categories['live2d'],
                'title'           => 'Paket Model Live2D Half-Body',
                'description'     => 'PSD model VTuber terpisah per layer rapi (mata, mulut, rambut, pakaian) siap untuk rigging Live2D Cubism.',
                'base_price'      => 600000,
                'estimated_days'  => 14,
                'max_revision'    => 3,
                'dp_percentage'   => 50,
                'available_slots' => 2,
                'request_type'    => 'custom',
                'sample_url'      => 'https://placehold.co/800x600/FFFDF0/1E293B.png?text=Viandra+Live2D+Model',
                'addon_title'     => 'Toggle Ekspresi Bonus (3 Set)',
                'addon_desc'      => 'Tiga layer ekspresi tambahan (blushing, starry eyes, shock).',
                'addon_price'     => 120000,
            ],
        ];

        foreach ($menuDefs as $def) {
            $menu = CommissionMenu::firstOrCreate(
                [
                    'artist_id' => $def['artist']->id,
                    'title'     => $def['title'],
                ],
                [
                    'category_id'     => $def['category']->id,
                    'description'     => $def['description'],
                    'base_price'      => $def['base_price'],
                    'estimated_days'  => $def['estimated_days'],
                    'max_revision'    => $def['max_revision'],
                    'dp_percentage'   => $def['dp_percentage'],
                    'available_slots' => $def['available_slots'],
                    'request_type'    => $def['request_type'],
                    'is_active'       => true,
                ]
            );

            CommissionSample::firstOrCreate(
                [
                    'commission_menu_id' => $menu->id,
                    'image_url'          => $def['sample_url'],
                ]
            );

            CommissionAddon::firstOrCreate(
                [
                    'commission_menu_id' => $menu->id,
                    'title'              => $def['addon_title'],
                ],
                [
                    'description' => $def['addon_desc'],
                    'price'       => $def['addon_price'],
                ]
            );
        }

        $portfolios = [
            [
                'artist'      => $rara,
                'title'       => 'Ilustrasi Karakter Kafe Senja',
                'image_url'   => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=Portfolio+Rara+1',
                'description' => 'Komisi karakter original dengan palet kuning pastel hangat dan pencahayaan sore.',
            ],
            [
                'artist'      => $rara,
                'title'       => 'Set Stiker & Chibi Maskot',
                'image_url'   => 'https://placehold.co/800x600/FFF9C4/1E293B.png?text=Portfolio+Rara+2',
                'description' => 'Kumpulan ilustrasi chibi ekspresif untuk kebutuhan komunitas streaming.',
            ],
            [
                'artist'      => $viandra,
                'title'       => 'Model VTuber Cyber Pastel',
                'image_url'   => 'https://placehold.co/800x600/FDF1A9/334155.png?text=Portfolio+Viandra+1',
                'description' => 'Model Live2D siap rigging lengkap dengan pemisahan layer rambut dan aksesori.',
            ],
            [
                'artist'      => $viandra,
                'title'       => 'Potret Semi-Realis Ksatria Cahaya',
                'image_url'   => 'https://placehold.co/800x600/FFFDF0/1E293B.png?text=Portfolio+Viandra+2',
                'description' => 'Ilustrasi karakter fantasi full-render untuk sampul novel digital.',
            ],
        ];

        foreach ($portfolios as $portfolio) {
            Portfolio::firstOrCreate(
                [
                    'artist_id' => $portfolio['artist']->id,
                    'title'     => $portfolio['title'],
                ],
                [
                    'image_url'   => $portfolio['image_url'],
                    'description' => $portfolio['description'],
                ]
            );
        }
    }
}
