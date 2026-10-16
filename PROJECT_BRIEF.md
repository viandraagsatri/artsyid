# SYSTEM CONTEXT & PROJECT BRIEF: ARTSY ID (Platform Komisi Karya Seni Digital)

## 1. PROJECT OVERVIEW
Nama Proyek: Artsy ID
Deskripsi: Platform web marketplace komisi karya seni digital (Art Commission). Sistem ini mempertemukan Artist (seniman) dan Client (pembeli), serta memiliki Admin sebagai pengawas.
Tujuan Utama: Mengatasi masalah penipuan (scam) dan scope creep dalam komisi seni dengan sistem pembayaran bertahap (Escrow/DP) dan fitur pelacakan progres (Progress Tracker) yang transparan.
Tech Stack: Laravel (Backend & MVC), Tailwind CSS (untuk styling UI/UX), PostgreSQL (Database).
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
1. Client (Pembeli): Bisa mencari artist, melihat ToS, membuat order (request), membayar tagihan (DP & Lunas) via Midtrans, melihat progress tracker, memberi revisi, dan review.
2. Artist (Seniman): Bisa mengatur profil & ToS, membuat katalog (menu komisi & add-ons), menerima/menolak request, update progress gambar (sketsa s.d rendering), menerbitkan dynamic invoice, dan mengirim file final.
3. Admin: Memverifikasi pendaftaran artist, menyetujui pencairan dana (payout) ke artist secara manual, menangani sengketa/report.

## 4. CORE BUSINESS LOGIC & FLOW (ALUR SISTEM)
- Flow Pemesanan: Client cari Artist -> Client isi form request & pilih add-ons -> Artist approve -> Sistem otomatis generate Invoice DP (50%).
- Flow Pembayaran (Escrow): Client bayar DP via Midtrans Snap -> Midtrans mengirim Webhook ke sistem -> Status jadi "On Progress" -> Uang ditahan di sistem.
- Flow Progress Tracker: Artist unggah update kerjaan (Sketsa -> Line Art -> Coloring -> Rendering). Sistem HARUS OTOMATIS menambahkan WATERMARK pada gambar yang diunggah di tahap ini. Client tidak bisa mengunduh file asli, hanya file review ber-watermark.
- Flow Pencairan Tahap 1: Setelah tahap "Line Art" disetujui Client, DP bisa dicairkan ke Artist oleh Admin.
- Flow Dynamic Invoice: Jika di tengah jalan Client minta tambahan (Add-ons), Artist bisa update tagihan pelunasan.
- Flow Pelunasan: Artist unggah hasil akhir (Rendering) -> Client acc -> Sistem generate Invoice Pelunasan -> Client bayar via Midtrans -> File tanpa watermark terbuka untuk diunduh -> Dana sisa dicairkan ke Artist.

## 5. CRITICAL TECHNICAL RULES FOR AI (MUST FOLLOW)
1. Database (PostgreSQL): Gunakan migrasi Laravel standar. Pastikan penggunaan tipe data yang tepat (misal: `decimal` untuk nominal uang, `jsonb` jika ada data dinamis). Perhatikan konvensi penamaan foreign key (constrained & cascade/restrict on delete).
2. Payment Gateway (Midtrans): 
   - Gunakan Midtrans Snap API untuk menampilkan popup pembayaran di frontend.
   - Buat route khusus untuk MIDTRANS WEBHOOK (Notification Handler) guna memproses perubahan status (settlement, pending, expire).
   - Route webhook INI HARUS DIKECUALIKAN DARI middleware CSRF (VerifyCsrfToken).
   - Selalu validasi Signature Key dari Midtrans di dalam controller webhook sebelum memperbarui status invoice di database.
3. MVC Pattern & Service Classes: Jaga controller tetap bersih. Simpan logika kalkulasi harga dan interaksi API Midtrans di dalam Service Classes tersendiri (contoh: `MidtransService`, `OrderService`).
4. Image Processing & Watermarking: Gunakan library `Intervention Image` untuk memproses watermark. Eksekusi proses watermarking menggunakan **Laravel Queue/Jobs** di background agar waktu respons upload cepat.
5. State Management (Status Order): Status order (pending_review, awaiting_dp, on_progress, review, revision, completed) sangat krusial. Gunakan ENUM di database dan validasi ketat setiap transisi statusnya.
6. Tailwind Integration: Saat membuat tampilan Blade, selalu gunakan utility classes Tailwind CSS sesuai dengan panduan warna kuning pastel dan font Poppins.
7. Database Schema Reference: Terdapat file migrasi dengan rancangan database PostgreSQL di dalam folder database/migrations gunakan migrasi tersebut sebagai acuan utama nama tabel, relasi, dan tipe data dll. dalam project ini.