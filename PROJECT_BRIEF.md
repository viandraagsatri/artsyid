# SYSTEM CONTEXT & PROJECT BRIEF: ARTSY ID (Platform Komisi Karya Seni Digital)

## 1. PROJECT OVERVIEW
Nama Proyek: Artsy ID
Deskripsi: Platform web marketplace komisi karya seni digital (Art Commission). Sistem ini mempertemukan Artist (seniman) dan Client (pembeli), serta memiliki Admin sebagai pengawas.
Tujuan Utama: Mengatasi masalah penipuan (scam) dan scope creep dalam komisi seni dengan sistem pembayaran bertahap (Escrow/DP) dan fitur pelacakan progres (Progress Tracker) yang transparan.
Tech Stack: Laravel 12 (Backend & MVC), Tailwind CSS (untuk styling UI/UX), PostgreSQL (Database).
Payment Gateway: Midtrans.

## 2. UI/UX & DESIGN GUIDELINES
Gaya Visual: Elegan, modern (kekinian), bersih (clean), dan user-friendly. Tidak kaku.
Tema Warna:
- Primary Color: Kuning Pastel (contoh: #FDF1A9 atau #FFF9C4) - gunakan untuk tombol utama, highlight, dan aksen elemen.
- Secondary/Background: Off-white (#FAFAFA) atau Putih bersih (#FFFFFF) agar karya seni (gambar) lebih menonjol.
- Text Color: Dark Slate/Charcoal (#1E293B atau #334155) untuk teks agar kontras dan mudah dibaca (jangan gunakan hitam pekat #000000).
- Accent/Status Colors: Hijau soft (untuk sukses/approved), Merah soft (untuk rejected/error), Biru pastel (untuk info).
Typography:
- Font Utama (Headings, Buttons, Navbar): **Poppins** (Elegan, modern, dan rapi).
- Font Pendukung (Body Text, Paragraf, Deskripsi panjang): **Inter** atau **Roboto** (Tingkat keterbacaan tinggi).
- UI Components: Gunakan rounded corners (rounded-lg atau rounded-xl) pada card, input, dan button. Beri soft shadow pada card katalog.

## 3. USER ROLES & PERMISSIONS
1. Client (Pembeli): Mencari artist, melihat ToS, membuat order (tipe custom atau instant), membayar invoice DP & Pelunasan via Midtrans Snap, memantau linimasa progres (view-only), mengajukan revisi terbatas, mengunduh karya final setelah pelunasan, serta memberikan rating, ulasan, & tip.
2. Artist (Seniman): Mengatur profil & ToS, mengelola rekening pencairan dana, membuat katalog komisi & paket add-ons, menerima/menolak pesanan custom, mengunggah draf progres gambar (otomatis di-watermark oleh sistem), menerbitkan dynamic invoice jika ada permintaan tambahan, dan mengunggah berkas final tanpa watermark.
3. Admin: Memverifikasi pendaftaran artist (`artist_applications`), mengaudit transaksi, memproses pencairan dana (*payout*) ke rekening artist setelah karya akhir disetujui, memproses transfer refund manual untuk pesanan yang dibatalkan, serta menangani laporan sengketa pengguna (`artist_reports`).

## 4. CORE BUSINESS LOGIC & FLOW (ALUR SISTEM)
- Flow Pemesanan:
  - **Tipe Custom**: Client isi form request & add-ons -> Menunggu review Artist (`pending_review`). Jika disetujui -> Sistem otomatis menerbitkan Invoice DP (50%). Jika ditolak -> Status pesanan menjadi `rejected`.
  - **Tipe Instant**: Client isi form request -> Melewati 4 tahap pengerjaan yang sama, namun langsung diterima otomatis oleh sistem tanpa antrean review manual artist -> Sistem langsung menerbitkan Invoice DP (50%).
- Flow Pembayaran DP (Escrow): Client bayar DP via Midtrans Snap -> Webhook Midtrans terverifikasi oleh sistem -> Status order berubah menjadi `on_progress` -> Dana DP ditahan secara aman di rekening Escrow sistem.
- Flow Progress Tracker: Linimasa 4 tahap wajib (Sketsa -> Line Art -> Coloring -> Rendering). Sistem HARUS OTOMATIS menambahkan WATERMARK diagonal pada setiap draf gambar yang diunggah di tahap 1 s.d 4. Client hanya dapat melihat preview ber-watermark dan TIDAK BISA mengunduh file asli beresolusi penuh sebelum pelunasan.
- Aturan Kuota Revisi: Kuota revisi (default 1-2x) berlaku secara akumulatif untuk keseluruhan tahapan pesanan (sepanjang pesanan), bukan per tahap. Jika kuota revisi gratis habis, revisi tambahan harus diajukan melalui Dynamic Invoice berbayar.
- Flow Dynamic Invoice: Jika di tengah jalan Client meminta tambahan add-on atau revisi ekstra via Chat, Artist menerbitkan Dynamic Invoice. Setelah Client menyetujui rincian biaya tersebut, nominalnya otomatis diakumulasikan ke tagihan pelunasan akhir (`final invoice`).
- Flow Pelunasan & Pencairan (Payout):
  - Artist menyelesaikan tahap Rendering -> Client menyetujui hasil akhir -> Sistem menerbitkan Invoice Pelunasan (sisa 50% + total akumulasi dynamic add-ons) -> Status `awaiting_final_payment`.
  - Client melunasi tagihan via Midtrans Snap -> Status order berubah menjadi `completed`.
  - Akses unduh berkas asli (tanpa watermark) resmi dibuka untuk Client melalui jalur terproteksi.
  - **Pencairan Dana Escrow**: Sistem mencatatkan entri Payout ke Admin untuk mentransfer dana komisi (DP + Pelunasan) secara penuh ke rekening bank Artist setelah karya akhir disetujui dan dilunasi.
- Flow Pembatalan & Refund:
  - Jika pesanan dibatalkan (misal Artist melewati batas waktu/deadline atau kesepakatan batal saat draf awal), status pesanan berubah menjadi `cancelled` lalu `refunded`.
  - Pengembalian dana DP (Refund) ke Client diproses melalui transfer manual oleh Admin.

## 5. CRITICAL TECHNICAL RULES FOR AI (MUST FOLLOW)
1. Database (PostgreSQL): Gunakan migrasi Laravel standar. Pastikan penggunaan tipe data yang tepat (misal: `decimal` untuk nominal uang, `jsonb` jika ada data dinamis). Perhatikan konvensi penamaan foreign key (constrained & cascade/restrict on delete).
2. Payment Gateway (Midtrans): 
   - Gunakan Midtrans Snap API untuk memunculkan popup pembayaran di antarmuka web.
   - Buat route khusus untuk MIDTRANS WEBHOOK (Notification Handler) guna memproses perubahan status transaksi (settlement, pending, expire).
   - Route webhook INI HARUS DIKECUALIKAN DARI middleware CSRF pada file `bootstrap/app.php` menggunakan method `$middleware->validateCsrfTokens(except: ['api/midtrans/notification', 'midtrans/notification'])`.
   - Selalu validasi Signature Key dari Midtrans di controller webhook sebelum memperbarui status invoice dan order di database.
3. MVC Pattern & Service Classes: Jaga controller tetap tipis. Wajib menggunakan Service Classes tersendiri di `app/Services/` (contoh: `MidtransService`, `OrderService`, `WatermarkService`, `PayoutService`).
4. Image Processing & Keamanan Berkas:
   - Gunakan library `Intervention Image` untuk memproses watermark draf WIP secara diagonal.
   - Eksekusi proses watermarking WAJIB dijalankan di background menggunakan **Laravel Queue/Jobs** (`WatermarkImageJob`) agar respons HTTP upload tetap cepat.
   - Berkas final beresolusi penuh tanpa watermark **WAJIB** disimpan di folder privat (`storage/app/private/`) dan hanya dapat diunduh melalui controller/route terproteksi yang memverifikasi bahwa pesanan berstatus `completed` dan invoice pelunasan telah lunas (`paid`).
5. State Management (Status Order): Status order sangat krusial (`pending_review`, `rejected`, `awaiting_dp`, `on_progress`, `review`, `revision`, `awaiting_final_payment`, `completed`, `cancelled`, `refunded`). Validasi ketat setiap transisi statusnya pada level database dan service.
6. Tailwind Integration: Saat membuat tampilan Blade, selalu gunakan utility classes Tailwind CSS sesuai dengan panduan warna kuning pastel dan font Poppins.
7. Database Schema Reference: File migrasi di `database/migrations` adalah acuan utama nama tabel, relasi, dan tipe data dalam project ini.
