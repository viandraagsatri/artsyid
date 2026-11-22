<?php

namespace Database\Seeders;

use App\Models\ArtistReport;
use App\Models\CommissionMenu;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $rafly = User::where('email', 'rafly@artsy.id')->firstOrFail();
        $rara = User::where('email', 'rara@artsy.id')->firstOrFail();
        $viandra = User::where('email', 'viandra@artsy.id')->firstOrFail();
        $dafa = User::where('email', 'dafa@artsy.id')->firstOrFail();
        $nadia = User::where('email', 'nadia@artsy.id')->firstOrFail();
        $bima = User::where('email', 'bima@artsy.id')->firstOrFail();
        $salsa = User::where('email', 'salsa@artsy.id')->firstOrFail();

        $menuRaraHalfBody = CommissionMenu::where('artist_id', $rara->id)
            ->where('title', 'Ilustrasi Half-Body Anime Pastel')
            ->firstOrFail();
        $menuRaraChibi = CommissionMenu::where('artist_id', $rara->id)
            ->where('title', 'Avatar Chibi 2D Ekspresif')
            ->firstOrFail();
        $menuViandraSemi = CommissionMenu::where('artist_id', $viandra->id)
            ->where('title', 'Ilustrasi Full-Body Semi-Realis')
            ->firstOrFail();
        $menuViandraLive2d = CommissionMenu::where('artist_id', $viandra->id)
            ->where('title', 'Paket Model Live2D Half-Body')
            ->firstOrFail();

        $order1 = Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-001'],
            [
                'client_id'           => $dafa->id,
                'artist_id'           => $rara->id,
                'commission_menu_id'  => $menuRaraHalfBody->id,
                'concept_description' => 'Karakter OC gadis sekolah berjaket kuning pastel memegang kamera analog di kafe.',
                'vibes'               => 'Hangat, Pastel, Cozy',
                'background_type'     => 'Interior Kafe',
                'character_count'     => 1,
                'request_type'        => 'custom',
                'status'              => 'completed',
                'base_amount'         => 300000,
                'addons_amount'       => 100000,
                'total_amount'        => 400000,
                'dp_amount'           => 200000,
                'final_amount'        => 200000,
                'deadline_at'         => now()->subDays(2),
            ]
        );

        $this->seedTracks($order1, [
            1 => ['stage_name' => 'Sketsa', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD001+Sketsa', 'approved_at' => now()->subDays(9)],
            2 => ['stage_name' => 'Line Art', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD001+LineArt', 'approved_at' => now()->subDays(7)],
            3 => ['stage_name' => 'Pewarnaan', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD001+Coloring', 'approved_at' => now()->subDays(5)],
            4 => ['stage_name' => 'Rendering', 'status' => 'completed', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD001+Render+WM', 'final_file_url' => 'https://placehold.co/1600x1200/FFFDF0/1E293B.png?text=ORD001+FINAL+HD', 'approved_at' => now()->subDays(3)],
        ]);

        $inv1Dp = $this->seedInvoice($order1, 'INV-ARTSY-001-DP', 'dp', 200000, 'paid', now()->subDays(10), now()->subDays(10), 'DP 50% Ilustrasi Half-Body + Add-on Background');
        $this->seedPayment($inv1Dp, 'TRX-ARTSY-001-DP', 200000, 'qris', 'settlement', now()->subDays(10), null, null, null, [
            'transaction_status' => 'settlement',
            'payment_type'       => 'qris',
            'gross_amount'       => '200000.00',
            'order_id'           => 'INV-ARTSY-001-DP',
        ]);

        $inv1Final = $this->seedInvoice($order1, 'INV-ARTSY-001-FINAL', 'final', 200000, 'paid', now()->subDays(3), now()->subDays(3), 'Pelunasan 50% ORD-ARTSY-001');
        $this->seedPayment(
            $inv1Final,
            'TRX-ARTSY-001-FINAL',
            200000,
            'bank_transfer',
            'approved',
            now()->subDays(3),
            null,
            $rafly->id,
            now()->subDays(3),
            [
                'transaction_status' => 'settlement',
                'payment_type'       => 'bank_transfer',
                'bank'               => 'bca',
                'va_number'          => '880012349911',
                'gross_amount'       => '200000.00',
                'admin_audit'        => [
                    'action'     => 'approved',
                    'admin_id'   => $rafly->id,
                    'admin_name' => $rafly->name,
                    'notes'      => 'Rekonsiliasi manual: settlement terkonfirmasi di dashboard Midtrans.',
                ],
            ]
        );

        Payout::updateOrCreate(
            ['order_id' => $order1->id, 'payout_stage' => 'final'],
            [
                'artist_id'             => $rara->id,
                'amount'                => 400000,
                'status'                => 'pending',
                'proof_of_transfer'     => null,
                'processed_by_admin_id' => null,
                'processed_at'          => null,
            ]
        );

        Review::firstOrCreate(
            ['order_id' => $order1->id],
            [
                'client_id'  => $dafa->id,
                'artist_id'  => $rara->id,
                'rating'     => 5,
                'comment'    => 'Hasil ilustrasi pastelnya rapi sekali dan komunikasi di setiap tahap sangat jelas.',
                'tip_amount' => 25000,
            ]
        );

        $order2 = Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-002'],
            [
                'client_id'           => $dafa->id,
                'artist_id'           => $rara->id,
                'commission_menu_id'  => $menuRaraHalfBody->id,
                'concept_description' => 'Karakter maskot komunitas gaming membawa headset bergaya anime cerah.',
                'vibes'               => 'Ceria, Enerjik',
                'background_type'     => 'Polos Pastel',
                'character_count'     => 1,
                'request_type'        => 'custom',
                'status'              => 'review',
                'base_amount'         => 300000,
                'addons_amount'       => 0,
                'total_amount'        => 300000,
                'dp_amount'           => 150000,
                'final_amount'        => 150000,
                'deadline_at'         => now()->addDays(4),
            ]
        );

        $this->seedTracks($order2, [
            1 => ['stage_name' => 'Sketsa', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD002+Sketsa', 'approved_at' => now()->subDays(2)],
            2 => ['stage_name' => 'Line Art', 'status' => 'review', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD002+LineArt+Preview', 'notes' => 'Silakan tinjau detail garis sebelum lanjut ke tahap pewarnaan.'],
            3 => ['stage_name' => 'Pewarnaan', 'status' => 'pending'],
            4 => ['stage_name' => 'Rendering', 'status' => 'pending'],
        ]);

        $inv2Dp = $this->seedInvoice($order2, 'INV-ARTSY-002-DP', 'dp', 150000, 'paid', now()->subDays(4), now()->subDays(4), 'DP 50% Ilustrasi Half-Body Maskot');
        $this->seedPayment($inv2Dp, 'TRX-ARTSY-002-DP', 150000, 'bank_transfer', 'settlement', now()->subDays(4), null, null, null, [
            'transaction_status' => 'settlement',
            'va_number'          => '880012349901',
            'bank'               => 'bca',
            'gross_amount'       => '150000.00',
        ]);

        $order3 = Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-003'],
            [
                'client_id'           => $dafa->id,
                'artist_id'           => $viandra->id,
                'commission_menu_id'  => $menuViandraSemi->id,
                'concept_description' => 'Ksatria cyberpunk berjubah biru slate dengan latar kota futuristik.',
                'vibes'               => 'Dramatis, Futuristik',
                'background_type'     => 'Kota Cyberpunk',
                'character_count'     => 1,
                'request_type'        => 'custom',
                'status'              => 'awaiting_dp',
                'base_amount'         => 450000,
                'addons_amount'       => 50000,
                'total_amount'        => 500000,
                'dp_amount'           => 250000,
                'final_amount'        => 250000,
                'deadline_at'         => now()->addDays(10),
            ]
        );

        $inv3Dp = $this->seedInvoice($order3, 'INV-ARTSY-003-DP', 'dp', 250000, 'unpaid', now()->addDays(2), null, 'DP 50% Ilustrasi Full-Body + Properti Senjata');
        $this->seedPayment(
            $inv3Dp,
            'TRX-ARTSY-003-DP',
            250000,
            'bank_transfer',
            'pending',
            null,
            null,
            null,
            null,
            [
                'transaction_status' => 'pending',
                'payment_type'       => 'bank_transfer',
                'bank'               => 'bca',
                'va_number'          => '880012349903',
                'status_message'     => 'Waiting for Midtrans webhook settlement',
                'gross_amount'       => '250000.00',
            ]
        );

        Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-004'],
            [
                'client_id'           => $nadia->id,
                'artist_id'           => $rara->id,
                'commission_menu_id'  => $menuRaraChibi->id,
                'concept_description' => 'Avatar chibi kembar bertema toko roti dengan warna kuning mentega dan cokelat lembut.',
                'vibes'               => 'Imut, Hangat',
                'background_type'     => 'Transparan PNG',
                'character_count'     => 1,
                'request_type'        => 'instant',
                'status'              => 'pending_review',
                'base_amount'         => 250000,
                'addons_amount'       => 0,
                'total_amount'        => 250000,
                'dp_amount'           => 125000,
                'final_amount'        => 125000,
                'deadline_at'         => now()->addDays(5),
            ]
        );

        $order5 = Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-005'],
            [
                'client_id'           => $salsa->id,
                'artist_id'           => $rara->id,
                'commission_menu_id'  => $menuRaraHalfBody->id,
                'concept_description' => 'Ilustrasi karakter penyihir bunga dengan efek kelopak melayang untuk banner profil.',
                'vibes'               => 'Magis, Lembut',
                'background_type'     => 'Taman Pastel',
                'character_count'     => 1,
                'request_type'        => 'custom',
                'status'              => 'on_progress',
                'base_amount'         => 350000,
                'addons_amount'       => 0,
                'total_amount'        => 350000,
                'dp_amount'           => 175000,
                'final_amount'        => 175000,
                'deadline_at'         => now()->addDays(6),
            ]
        );

        $this->seedTracks($order5, [
            1 => ['stage_name' => 'Sketsa', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD005+Sketsa', 'approved_at' => now()->subDays(3)],
            2 => ['stage_name' => 'Line Art', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD005+LineArt', 'approved_at' => now()->subDay()],
            3 => ['stage_name' => 'Pewarnaan', 'status' => 'pending'],
            4 => ['stage_name' => 'Rendering', 'status' => 'pending'],
        ]);

        $inv5Dp = $this->seedInvoice($order5, 'INV-ARTSY-005-DP', 'dp', 175000, 'paid', now()->subDays(5), now()->subDays(5), 'DP 50% Ilustrasi Penyihir Bunga');
        $this->seedPayment($inv5Dp, 'TRX-ARTSY-005-DP', 175000, 'gopay', 'settlement', now()->subDays(5), null, null, null, [
            'transaction_status' => 'settlement',
            'payment_type'       => 'gopay',
            'gross_amount'       => '175000.00',
        ]);

        $inv5Dyn = $this->seedInvoice($order5, 'INV-ARTSY-005-DYN', 'dynamic', 75000, 'unpaid', now()->addDays(3), null, 'Add-on Dinamis: Tambahan Peliharaan Kucing & Aura Bunga');
        $this->seedPayment(
            $inv5Dyn,
            'TRX-ARTSY-005-DYN',
            75000,
            'qris',
            'pending',
            null,
            null,
            null,
            null,
            [
                'transaction_status' => 'pending',
                'payment_type'       => 'qris',
                'acquirer'           => 'gopay',
                'status_message'     => 'Waiting for Midtrans webhook settlement',
                'gross_amount'       => '75000.00',
            ]
        );

        $order6 = Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-006'],
            [
                'client_id'           => $bima->id,
                'artist_id'           => $viandra->id,
                'commission_menu_id'  => $menuViandraLive2d->id,
                'concept_description' => 'Model VTuber Live2D half-body pria berkacamata bertema astronomi.',
                'vibes'               => 'Elegan, Misterius',
                'background_type'     => 'Transparan PSD',
                'character_count'     => 1,
                'request_type'        => 'custom',
                'status'              => 'awaiting_final_payment',
                'base_amount'         => 600000,
                'addons_amount'       => 0,
                'total_amount'        => 600000,
                'dp_amount'           => 300000,
                'final_amount'        => 300000,
                'deadline_at'         => now()->addDays(2),
            ]
        );

        $this->seedTracks($order6, [
            1 => ['stage_name' => 'Sketsa', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD006+Sketsa', 'approved_at' => now()->subDays(11)],
            2 => ['stage_name' => 'Line Art', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD006+LineArt', 'approved_at' => now()->subDays(8)],
            3 => ['stage_name' => 'Pewarnaan', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD006+Coloring', 'approved_at' => now()->subDays(4)],
            4 => ['stage_name' => 'Rendering', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD006+Render+WM', 'approved_at' => now()->subDay()],
        ]);

        $inv6Dp = $this->seedInvoice($order6, 'INV-ARTSY-006-DP', 'dp', 300000, 'paid', now()->subDays(12), now()->subDays(12), 'DP 50% Paket Model Live2D Half-Body');
        $this->seedPayment($inv6Dp, 'TRX-ARTSY-006-DP', 300000, 'bank_transfer', 'settlement', now()->subDays(12), null, null, null, [
            'transaction_status' => 'settlement',
            'bank'               => 'bni',
            'gross_amount'       => '300000.00',
        ]);


        $inv6Final = $this->seedInvoice($order6, 'INV-ARTSY-006-FINAL', 'final', 300000, 'unpaid', now()->addDays(2), null, 'Pelunasan 50% Paket Model Live2D Half-Body');
        $this->seedPayment(
            $inv6Final,
            'TRX-ARTSY-006-FINAL',
            300000,
            'gopay',
            'pending',
            null,
            null,
            null,
            null,
            [
                'transaction_status' => 'pending',
                'payment_type'       => 'gopay',
                'status_message'     => 'Waiting for Midtrans webhook settlement',
                'gross_amount'       => '300000.00',
            ]
        );

        $order7 = Order::updateOrCreate(
            ['order_number' => 'ORD-ARTSY-007'],
            [
                'client_id'           => $dafa->id,
                'artist_id'           => $viandra->id,
                'commission_menu_id'  => $menuViandraSemi->id,
                'concept_description' => 'Ilustrasi full-body pemanah hutan musim gugur dengan latar pepohonan keemasan.',
                'vibes'               => 'Epik, Hangat',
                'background_type'     => 'Hutan Musim Gugur',
                'character_count'     => 1,
                'request_type'        => 'custom',
                'status'              => 'revision',
                'base_amount'         => 450000,
                'addons_amount'       => 0,
                'total_amount'        => 450000,
                'dp_amount'           => 225000,
                'final_amount'        => 225000,
                'deadline_at'         => now()->addDays(1),
            ]
        );

        $this->seedTracks($order7, [
            1 => ['stage_name' => 'Sketsa', 'status' => 'approved', 'watermarked_image_url' => 'https://placehold.co/800x600/FDF1A9/1E293B.png?text=ORD007+Sketsa', 'approved_at' => now()->subDays(8)],
            2 => ['stage_name' => 'Line Art', 'status' => 'revision', 'watermarked_image_url' => 'https://placehold.co/800x600/FEF2F2/991B1B.png?text=ORD007+LineArt+Revisi', 'notes' => 'Mohon sesuaikan sudut busur panah dan ekspresi mata agar lebih tegas.'],
            3 => ['stage_name' => 'Pewarnaan', 'status' => 'pending'],
            4 => ['stage_name' => 'Rendering', 'status' => 'pending'],
        ]);

        $inv7Dp = $this->seedInvoice($order7, 'INV-ARTSY-007-DP', 'dp', 225000, 'paid', now()->subDays(9), now()->subDays(9), 'DP 50% Ilustrasi Pemanah Musim Gugur');
        $this->seedPayment($inv7Dp, 'TRX-ARTSY-007-DP-FAIL', 225000, 'qris', 'expire', now()->subDays(9)->subHours(3), null, null, null, [
            'transaction_status' => 'expire',
            'status_message'     => 'QRIS payment expired before scan',
            'gross_amount'       => '225000.00',
        ]);
        $this->seedPayment($inv7Dp, 'TRX-ARTSY-007-DP', 225000, 'qris', 'settlement', now()->subDays(9), null, null, null, [
            'transaction_status' => 'settlement',
            'payment_type'       => 'qris',
            'gross_amount'       => '225000.00',
        ]);

        ArtistReport::firstOrCreate(
            [
                'reporter_id' => $dafa->id,
                'artist_id'   => $viandra->id,
                'order_id'    => $order7->id,
                'reason'      => 'Keterlambatan Revisi Line Art',
            ],
            [
                'description'       => 'Permintaan revisi Line Art pada ORD-ARTSY-007 belum mendapatkan pembaruan melebihi estimasi waktu.',
                'evidence_file_url' => 'https://placehold.co/800x600/FEF2F2/991B1B.png?text=Bukti+Chat+ORD007',
                'status'            => 'pending',
            ]
        );

        Payout::whereIn('order_id', [$order1->id, $order5->id, $order6->id])
            ->where('payout_stage', 'dp')
            ->delete();
    }

    private function seedTracks(Order $order, array $tracks): void
    {
        foreach ($tracks as $step => $data) {
            OrderTrack::firstOrCreate(
                [
                    'order_id'   => $order->id,
                    'step_order' => $step,
                ],
                [
                    'stage_name'            => $data['stage_name'],
                    'status'                => $data['status'],
                    'watermarked_image_url' => $data['watermarked_image_url'] ?? null,
                    'final_file_url'        => $data['final_file_url'] ?? null,
                    'notes'                 => $data['notes'] ?? null,
                    'approved_at'           => $data['approved_at'] ?? null,
                ]
            );
        }
    }

    private function seedInvoice(
        Order $order,
        string $invoiceNumber,
        string $type,
        float $amount,
        string $status,
        $dueDate,
        $paidAt,
        string $itemName
    ): Invoice {
        $invoice = Invoice::updateOrCreate(
            ['invoice_number' => $invoiceNumber],
            [
                'order_id'     => $order->id,
                'invoice_type' => $type,
                'amount'       => $amount,
                'status'       => $status,
                'due_date'     => $dueDate,
                'paid_at'      => $paidAt,
            ]
        );

        InvoiceItem::firstOrCreate(
            [
                'invoice_id' => $invoice->id,
                'item_name'  => $itemName,
            ],
            [
                'qty'      => 1,
                'price'    => $amount,
                'subtotal' => $amount,
            ]
        );

        return $invoice;
    }

    private function seedPayment(
        Invoice $invoice,
        string $transactionId,
        float $amount,
        string $method,
        string $status,
        $paidAt,
        ?string $proofUrl,
        ?int $verifiedByAdminId,
        $verifiedAt,
        ?array $payload
    ): Payment {
        return Payment::updateOrCreate(
            ['transaction_id' => $transactionId],
            [
                'invoice_id'           => $invoice->id,
                'amount'               => $amount,
                'snap_token'           => 'snap-' . strtolower($transactionId),
                'payment_method'       => $method,
                'payment_status'       => $status,
                'proof_of_payment'     => $proofUrl,
                'payload'              => $payload,
                'paid_at'              => $paidAt,
                'verified_by_admin_id' => $verifiedByAdminId,
                'verified_at'          => $verifiedAt,
            ]
        );
    }
}
