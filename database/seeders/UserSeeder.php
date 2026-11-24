<?php

namespace Database\Seeders;

use App\Models\ArtistApplication;
use App\Models\ArtistProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        $users = [
            'rafly' => User::updateOrCreate(
                ['email' => 'rafly@artsy.id'],
                [
                    'name'         => 'Rafly Saputra',
                    'password'     => $password,
                    'bio'          => 'Administrator utama Artsy ID yang mengelola verifikasi artist, audit transaksi escrow, dan pencairan dana.',
                    'role'         => 'admin',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'rara' => User::updateOrCreate(
                ['email' => 'rara@artsy.id'],
                [
                    'name'         => 'Rara Aulia',
                    'password'     => $password,
                    'bio'          => 'Ilustrator anime pastel dan chibi karakter 2D dengan pengalaman komisi sejak 2022.',
                    'role'         => 'artist',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'viandra' => User::updateOrCreate(
                ['email' => 'viandra@artsy.id'],
                [
                    'name'         => 'Viandra Putri',
                    'password'     => $password,
                    'bio'          => 'Desainer karakter semi-realis dan model Live2D VTuber siap rigging.',
                    'role'         => 'artist',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'dafa' => User::updateOrCreate(
                ['email' => 'dafa@artsy.id'],
                [
                    'name'         => 'Dafa Pratama',
                    'password'     => $password,
                    'bio'          => 'Kreator konten dan kolektor ilustrasi karakter original.',
                    'role'         => 'user',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'nadia' => User::updateOrCreate(
                ['email' => 'nadia@artsy.id'],
                [
                    'name'         => 'Nadia Kusuma',
                    'password'     => $password,
                    'bio'          => 'Ilustrator chibi dan emote streaming yang sedang mengajukan akun artist.',
                    'role'         => 'user',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'bima' => User::updateOrCreate(
                ['email' => 'bima@artsy.id'],
                [
                    'name'         => 'Bima Mahendra',
                    'password'     => $password,
                    'bio'          => 'Konsep artist latar fantasi dan ilustrasi sampul buku.',
                    'role'         => 'user',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'salsa' => User::updateOrCreate(
                ['email' => 'salsa@artsy.id'],
                [
                    'name'         => 'Salsa Wijaya',
                    'password'     => $password,
                    'bio'          => 'Penggemar seni digital dan pelanggan aktif komisi di Artsy ID.',
                    'role'         => 'user',
                    'is_blocked'   => false,
                    'blocked_at'   => null,
                    'block_reason' => null,
                ]
            ),
            'bagas' => User::updateOrCreate(
                ['email' => 'bagas@artsy.id'],
                [
                    'name'         => 'Bagas Santoso',
                    'password'     => $password,
                    'bio'          => null,
                    'role'         => 'user',
                    'is_blocked'   => true,
                    'blocked_at'   => now()->subDays(3),
                    'block_reason' => 'Terindikasi melakukan spam pengajuan komisi dan pelanggaran ketentuan platform.',
                ]
            ),
        ];

        $profiles = [
            'rara' => [
                'bank_name'      => 'BCA',
                'account_number' => '8120445901',
                'account_holder' => 'Rara Aulia',
                'tos'            => [
                    'bisa_digambar'  => ['Karakter Original (OC)', 'Fanart Anime & Game', 'Chibi Couple'],
                    'tidak_menerima' => ['NSFW / Konten Dewasa', 'Mecha Rumit', 'Gore Ekstrem'],
                ],
            ],
            'viandra' => [
                'bank_name'      => 'Mandiri',
                'account_number' => '1370098123456',
                'account_holder' => 'Viandra Putri',
                'tos'            => [
                    'bisa_digambar'  => ['Semi-Realis Potret', 'Model Live2D VTuber', 'Kostum Fantasi Detail'],
                    'tidak_menerima' => ['NSFW', 'Hate Speech / SARA', 'Replikasi Gaya Artist Lain'],
                ],
            ],
            'nadia' => [
                'bank_name'      => 'BNI',
                'account_number' => '0845123980',
                'account_holder' => 'Nadia Kusuma',
                'tos'            => [
                    'bisa_digambar'  => ['Emote Twitch & YouTube', 'Chibi Ikon Profil', 'Maskot Lucu'],
                    'tidak_menerima' => ['NSFW', 'Realisme Wajah Tokoh Publik'],
                ],
            ],
            'bima' => [
                'bank_name'      => 'BRI',
                'account_number' => '034101045678502',
                'account_holder' => 'Bima Mahendra',
                'tos'            => [
                    'bisa_digambar'  => ['Environment & Background', 'Ilustrasi Sampul Novel', 'Monster & Makhluk Fantasi'],
                    'tidak_menerima' => ['NSFW', 'Karya AI Trace'],
                ],
            ],
            'salsa' => [
                'bank_name'      => 'BCA',
                'account_number' => '5271009832',
                'account_holder' => 'Salsa Wijaya',
                'tos'            => [
                    'bisa_digambar'  => ['Line Art Karakter', 'Ilustrasi Pastel Sederhana'],
                    'tidak_menerima' => ['NSFW', 'Furry Berat'],
                ],
            ],
        ];

        foreach ($profiles as $key => $profileData) {
            ArtistProfile::updateOrCreate(
                ['user_id' => $users[$key]->id],
                $profileData
            );
        }

        ArtistApplication::firstOrCreate(
            [
                'user_id'               => $users['rara']->id,
                'verification_file_url' => 'https://behance.net/rara-aulia/pastel-character-art',
            ],
            [
                'status'      => 'approved',
                'admin_notes' => 'Portofolio konsisten dan data rekening valid.',
                'created_at'  => now()->subDays(14),
                'updated_at'  => now()->subDays(13),
            ]
        );

        ArtistApplication::firstOrCreate(
            [
                'user_id'               => $users['viandra']->id,
                'verification_file_url' => 'https://artstation.com/viandra-putri/live2d-showcase',
            ],
            [
                'status'      => 'approved',
                'admin_notes' => 'Karya Live2D dan ilustrasi memenuhi standar Artsy ID.',
                'created_at'  => now()->subDays(12),
                'updated_at'  => now()->subDays(11),
            ]
        );

        ArtistApplication::firstOrCreate(
            [
                'user_id'               => $users['nadia']->id,
                'verification_file_url' => 'https://behance.net/nadia-kusuma/chibi-samples',
            ],
            [
                'status'      => 'pending',
                'admin_notes' => null,
                'created_at'  => now()->subDays(2),
                'updated_at'  => now()->subDays(2),
            ]
        );

        ArtistApplication::firstOrCreate(
            [
                'user_id'               => $users['bima']->id,
                'verification_file_url' => 'https://behance.net/bima-mahendra/draft-v1',
            ],
            [
                'status'      => 'rejected',
                'admin_notes' => 'Tautan portofolio pertama belum menampilkan minimal 3 karya original.',
                'created_at'  => now()->subDays(6),
                'updated_at'  => now()->subDays(6),
            ]
        );

        ArtistApplication::firstOrCreate(
            [
                'user_id'               => $users['bima']->id,
                'verification_file_url' => 'https://artstation.com/bima-mahendra/concept-art-final',
            ],
            [
                'status'      => 'pending',
                'admin_notes' => null,
                'created_at'  => now()->subDay(),
                'updated_at'  => now()->subDay(),
            ]
        );

        ArtistApplication::firstOrCreate(
            [
                'user_id'               => $users['salsa']->id,
                'verification_file_url' => 'https://deviantart.com/salsa-wijaya/sketch-collection',
            ],
            [
                'status'      => 'rejected',
                'admin_notes' => 'Portofolio masih berupa sketsa belum selesai. Silakan lengkapi sampel akhir lalu ajukan ulang.',
                'created_at'  => now()->subDays(5),
                'updated_at'  => now()->subDays(4),
            ]
        );
    }
}
