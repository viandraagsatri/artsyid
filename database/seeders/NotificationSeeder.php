<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admins = User::where('role', 'admin')
            ->where('is_blocked', false)
            ->get();

        $adminNotifications = [
            [
                'title'   => 'Pengajuan Artist Baru',
                'message' => 'Nadia Kusuma mendaftar menjadi artist dan menunggu peninjauan berkas portofolio serta rekening.',
                'link'    => '/admin/applications?status=pending',
                'is_read' => false,
            ],
            [
                'title'   => 'Pengajuan Ulang Artist',
                'message' => 'Bima Mahendra mengajukan ulang permohonan verifikasi artist untuk Anda tinjau.',
                'link'    => '/admin/applications?status=pending',
                'is_read' => false,
            ],
            [
                'title'   => 'Antrean Pencairan Dana Baru',
                'message' => 'Dana komisi penuh sebesar Rp 400.000 untuk pesanan selesai ORD-ARTSY-001 (Rara Aulia) siap ditransfer ke rekening artist.',
                'link'    => '/admin/payouts',
                'is_read' => false,
            ],
            [
                'title'   => 'Laporan Sengketa Baru',
                'message' => 'Dafa Pratama melaporkan kendala keterlambatan revisi pada pesanan ORD-ARTSY-007 terhadap Viandra Putri.',
                'link'    => '/admin/reports',
                'is_read' => false,
            ],
            [
                'title'   => 'Verifikasi Pembayaran Selesai',
                'message' => 'Pelunasan invoice INV-ARTSY-001-FINAL sebesar Rp 200.000 berhasil diverifikasi.',
                'link'    => '/admin/payments?status=success',
                'is_read' => true,
            ],
        ];

        foreach ($admins as $admin) {
            foreach ($adminNotifications as $item) {
                $this->seedNotification($admin->id, $item['title'], $item['link'], $item['message'], $item['is_read']);
            }
        }

        $rara = User::where('email', 'rara@artsy.id')->first();
        if ($rara) {
            $raraItems = [
                [
                    'title'   => 'Pesanan Komisi Baru',
                    'message' => 'Nadia Kusuma mengajukan komisi baru ORD-ARTSY-004 dan menunggu konfirmasi Anda.',
                    'link'    => '/artist/orders',
                    'is_read' => false,
                ],
                [
                    'title'   => 'Pencairan Dana Dalam Antrean',
                    'message' => 'Pencairan dana komisi penuh sebesar Rp 400.000 untuk pesanan ORD-ARTSY-001 telah masuk antrean transfer admin.',
                    'link'    => '/artist/payouts',
                    'is_read' => false,
                ],
                [
                    'title'   => 'Pengajuan Artist Disetujui!',
                    'message' => 'Selamat! Akun artist Anda aktif dan katalog komisi sudah tampil untuk calon pembeli.',
                    'link'    => '/profile/katalog',
                    'is_read' => true,
                ],
            ];

            foreach ($raraItems as $item) {
                $this->seedNotification($rara->id, $item['title'], $item['link'], $item['message'], $item['is_read']);
            }
        }

        $viandra = User::where('email', 'viandra@artsy.id')->first();
        if ($viandra) {
            $viandraItems = [
                [
                    'title'   => 'Permintaan Revisi WIP',
                    'message' => 'Dafa Pratama meminta penyesuaian pada tahap Line Art pesanan ORD-ARTSY-007.',
                    'link'    => '/artist/tracker',
                    'is_read' => false,
                ],
                [
                    'title'   => 'Pengajuan Artist Disetujui!',
                    'message' => 'Akun artist Anda aktif. Kelola paket komisi dan portofolio Anda melalui dashboard.',
                    'link'    => '/profile/katalog',
                    'is_read' => true,
                ],
            ];

            foreach ($viandraItems as $item) {
                $this->seedNotification($viandra->id, $item['title'], $item['link'], $item['message'], $item['is_read']);
            }
        }

        $dafa = User::where('email', 'dafa@artsy.id')->first();
        if ($dafa) {
            $dafaItems = [
                [
                    'title'   => 'Draf Line Art Siap Ditinjau',
                    'message' => 'Rara Aulia telah mengunggah pembaruan ber-watermark tahap Line Art pada pesanan ORD-ARTSY-002.',
                    'link'    => '/user/orders',
                    'is_read' => false,
                ],
                [
                    'title'   => 'Tagihan DP Menunggu Pembayaran',
                    'message' => 'Pesanan ORD-ARTSY-003 diterima oleh Viandra Putri. Segera selesaikan pembayaran DP melalui Midtrans Snap.',
                    'link'    => '/user/invoices',
                    'is_read' => false,
                ],
            ];

            foreach ($dafaItems as $item) {
                $this->seedNotification($dafa->id, $item['title'], $item['link'], $item['message'], $item['is_read']);
            }
        }

        $salsa = User::where('email', 'salsa@artsy.id')->first();
        if ($salsa) {
            $this->seedNotification(
                $salsa->id,
                'Pengajuan Artist Ditolak',
                '/register/artist',
                'Mohon maaf, pengajuan menjadi artist belum dapat kami setujui. Alasan: Portofolio masih berupa sketsa belum selesai. Silakan lengkapi sampel akhir lalu ajukan ulang.',
                false
            );
        }
    }

    private function seedNotification(int $userId, string $title, string $linkUrl, string $message, bool $isRead): void
    {
        $existing = Notification::where('user_id', $userId)
            ->where('title', $title)
            ->where('link_url', $linkUrl)
            ->first();

        if ($existing) {
            if ($existing->message !== $message) {
                $existing->update(['message' => $message]);
            }

            return;
        }

        Notification::create([
            'user_id'  => $userId,
            'title'    => $title,
            'link_url' => $linkUrl,
            'message'  => $message,
            'is_read'  => $isRead,
        ]);
    }
}
