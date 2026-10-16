# ARTSY ID — AGENT DEVELOPMENT & ARCHITECTURE GUIDELINES
> Dokumen ini adalah panduan baku dan aturan wajib (*strict guidelines*) untuk seluruh AI Agent atau pengembang yang bekerja pada repositori **Artsy ID**. Setiap implementasi kode, fitur, dan antarmuka harus mematuhi aturan di bawah ini.

---

## 1. DESKRIPSI & PRINSIP UTAMA PROYEK
- **Nama Proyek**: Artsy ID
- **Domain**: Marketplace Komisi Seni Digital Berbasis Web (*Web-based Digital Art Commission Platform*).
- **Tujuan Utama**: Menghilangkan risiko penipuan (*scam*), pembatalan sepihak, dan beban kerja tambahan tanpa bayaran (*scope creep*) melalui sistem pembayaran bertahap (**Escrow**) dan pelacakan transparan (**Progress Tracker**).
- **3 Hak Akses (Multi-Role)**:
  1. **Client (User)**: Eksplorasi katalog & ToS artist, submit request komisi, membayar invoice DP & Pelunasan via Midtrans Snap, memantau linimasa progres (view-only), chat internal, meminta revisi terbatas, unduh karya final, memberi rating, ulasan, & tip, serta opsi mendaftar menjadi artist atau melapor artist bermasalah.
  2. **Artist**: Kelola profil, portofolio, rekening bank (pencairan dana), dan ToS. Membuat katalog komisi & paket add-ons. Meninjau request (terima/tolak). Mengunggah update berkas progres (otomatis diberi watermark oleh sistem). Menerbitkan dynamic invoice jika ada penambahan add-on di tengah jalan. Mengunggah berkas final tanpa watermark.
  3. **Admin**: Verifikasi berkas pengajuan artist (`artist_applications`). Audit log transaksi & pesanan. Memproses pencairan dana (**Payout**) manual:
     - Tahap 1: Pencairan DP (setelah tahap *Line Art* selesai & disetujui Client).
     - Tahap 2: Pencairan Pelunasan (setelah Client menerima karya akhir).
     Menindaklanjuti laporan pengguna (`artist_reports`) dan memblokir akun artist jika terbukti bermasalah atau mendapat > 3 laporan dari pembeli berbeda.

---

## 2. ATURAN ARSITEKTUR & STRUKTUR KODE (BACKEND & MVC)
1. **Thin Controller, Fat Service**:
   - Jangan meletakkan logika bisnis kompleks di Controller.
   - Gunakan **Service Classes** tersendiri di `app/Services/`:
     - `MidtransService`: Logika Snap Token, Webhook Notification Handler, dan verifikasi Signature Key.
     - `OrderService`: Perhitungan harga dasar, add-ons, kalkulasi DP (50%), transisi status pesanan.
     - `WatermarkService`: Pemrosesan penambahan watermark pada gambar WIP via *Intervention Image*.
     - `PayoutService`: Logika pengajuan pencairan dana ke admin.
2. **Background Queue / Jobs**:
   - Proses watermarking gambar beresolusi tinggi **WAJIB** dijalankan di background menggunakan Laravel Queue Job (`WatermarkImageJob`) agar respons HTTP upload tetap cepat dan tidak timeout.
3. **Form Request & Validasi Ketat**:
   - Gunakan file Form Request (`php artisan make:request ...`) untuk validasi input form pemesanan, invoice, chat, profil, dan review.
4. **Midtrans Webhook Security**:
   - Route webhook Midtrans **HARUS DIKECUALIKAN** dari middleware CSRF (`VerifyCsrfToken` / bootstrap exceptions).
   - Validasi `signature_key` dari Midtrans (`SHA512(order_id + status_code + gross_amount + ServerKey)`) sebelum memperbarui status invoice/pembayaran di database.

---

## 3. INTEGRITAS DATABASE & RELASI (POSTGRESQL)
Database menggunakan PostgreSQL dengan 23 tabel terstruktur:
1. `users`: Id, name, email, password, role (`user`, `artist`, `admin`), avatar_url, is_blocked, blocked_at, block_reason.
2. `artist_applications`: Pengajuan menjadi artist (verifikasi berkas KTP/portofolio oleh admin).
3. `artist_profiles`: Bio, bank_name, account_number, account_holder, tos (singkat & lengkap).
4. `categories`: Kategori seni (Avatar 2D, Model 3D, Ilustrasi, Emote, dll.).
5. `portfolios`: Galeri portofolio karya artist.
6. `commission_menus`: Paket komisi (base_price, estimated_days, max_revision, dp_percentage, available_slots, request_type).
7. `commission_samples`: Sampel gambar contoh pada tiap menu komisi.
8. `commission_addons`: Opsi tambahan (background detail, karakter ekstra, commercial use).
9. `orders`: Pesanan komisi (order_number, client_id, artist_id, status, total_amount, dp_amount, final_amount, dll.).
10. `order_addons`: Add-on yang dipilih pada pesanan (termasuk add-on dinamis).
11. `order_references`: Berkas/gambar referensi dari client.
12. `order_tracks`: Tahapan linimasa progres (order_id, step_order, stage_name, status, watermarked_image_url, final_file_url).
13. `order_revisions`: Catatan pengajuan revisi per track.
14. `invoices`: Tagihan bertahap (`dp`, `final`, `dynamic`).
15. `invoice_items`: Rincian item tagihan.
16. `payments`: Transaksi pembayaran (amount, snap_token, payment_method, payment_status, payload json, proof_of_payment).
17. `payouts`: Rekaman pencairan dana escrow dari admin ke rekening artist (`dp`, `final`).
18. `order_chats`: Chat internal antar Client & Artist per order.
19. `notifications`: Notifikasi aktivitas sistem ke pengguna.
20. `reviews`: Rating (1-5), ulasan teks, dan tip_amount untuk pesanan selesai.
21. `artist_reports`: Laporan pembeli terhadap artist bermasalah.

> **Aturan Migrasi**: Jangan pernah menghapus atau mengubah tipe data tabel yang sudah berjalan tanpa sinkronisasi yang jelas. Gunakan foreign key `cascadeOnDelete()` untuk child detail dan `restrictOnDelete()` untuk transaksi penting.

---

## 4. ATURAN STATE MACHINE & CORE BUSINESS FLOW

### A. Alur Pemesanan & Pembayaran Escrow
```
[Client Request Form]
       │
       ▼
[Menunggu Konfirmasi Artist: 'pending_review']
       │
       ├─► [Artist Tolak] ──► Status: 'rejected'
       │
       └─► [Artist Terima]
               │
               ▼
   [Sistem Buat Invoice DP (50%)]
   [Status: 'awaiting_dp']
               │
               ▼ (Client Bayar via Midtrans Snap / Webhook Terverifikasi)
   [Dana DP Masuk Escrow Sistem]
   [Status: 'on_progress']
```

### B. Alur Progress Tracker 4 Tahap & Proteksi Watermark
Setiap pesanan memiliki linimasa 4 tahap wajib:
1. **Tahap 1: Sketsa (*Sketch*)**
2. **Tahap 2: Line Art** $\rightarrow$ **TITIK KRUSIAL PENCAIRAN DP**:
   - Ketika Client menyetujui tahap Line Art, sistem **otomatis** membuat entri `payouts` dengan `payout_stage = 'dp'` dan status `pending`.
   - Admin memeriksa bukti di dashboard dan mentransfer DP ke rekening artist.
3. **Tahap 3: Pewarnaan (*Coloring*)**
4. **Tahap 4: Penyelesaian / Rendering (*Rendering*)**

> **ATURAN MUTLAK WATERMARK**:
> Setiap gambar yang diunggah artist selama tahap 1 s.d 4 **WAJIB** dipasangi watermark "ARTSY ID - PREVIEW ONLY" secara diagonal. Client **HANYA** dapat melihat gambar ber-watermark dan TIDAK BISA mengunduh file asli beresolusi penuh sebelum pelunasan!

### C. Alur Dynamic Invoice (Permintaan Tambahan di Tengah Jalan)
- Jika Client meminta add-on baru di tengah pengerjaan via Chat, Artist menerbitkan `Dynamic Invoice`.
- Client menerima notifikasi dan tombol persetujuan rincian biaya.
- Setelah disetujui, nominal ditambahkan ke tagihan pelunasan akhir.

### D. Alur Pelunasan & Serah Terima Karya Final
```
[Rendering Disetujui Client]
       │
       ▼
[Sistem Terbitkan Invoice Pelunasan (Sisa 50% + Add-ons Dinamis)]
[Status: 'awaiting_final_payment']
       │
       ▼ (Client Bayar Pelunasan via Midtrans)
[Status: 'completed']
       │
       ├─► Akses Unduh File Asli (Tanpa Watermark) Terbuka untuk Client
       ├─► Sistem Mengantrekan Payout Pelunasan ke Admin untuk Artist
       └─► Form Review, Rating, & Tip Aktif untuk Client
```

---

## 5. UI/UX & ATURAN DESIGN SYSTEM (TAILWIND CSS)
1. **Warna Wajib Sesuai Brief**:
   - **Primary Color**: Kuning Pastel (`#FDF1A9` / `#FFF9C4`, class: `bg-pastel-200`, `hover:bg-pastel-300`, `bg-pastel-100`).
   - **Text Color**: Dark Slate / Charcoal (`#1E293B` / `#334155`, class: `text-slate-dark`, `text-slate-body`). **Dilarang memakai warna hitam pekat (`#000000`)**.
   - **Background**: Off-white (`#FAFAFA`, class: `bg-bg-light`) agar portofolio gambar artist menonjol.
   - **Status Colors**:
     - Hijau Soft (`#ECFDF5`, text: `#065F46`) untuk Sukses / Disetujui.
     - Merah Soft (`#FEF2F2`, text: `#991B1B`) untuk Ditolak / Batal / Error.
     - Biru Pastel (`#F0F9FF`, text: `#075985`) untuk Info / Pending.
2. **Tipografi Wajib**:
   - Judul, Heading (`<h1>`-`<h6>`), Navbar, dan Tombol: **Poppins** (font-heading).
   - Teks Paragraf & Konten Panjang: **Inter** (font-sans).
3. **Komponen UI**:
   - Gunakan rounded corners modern (`rounded-xl` atau `rounded-2xl`).
   - Berikan bayangan lembut (*soft shadow*) pada kartu katalog: class `.card-artsy` atau `shadow-xs hover:shadow-md`.
   - Tombol utama wajib menggunakan class `.btn-primary` atau kombinasi `bg-pastel-200 hover:bg-pastel-300 text-slate-900 rounded-xl font-heading font-semibold`.

---

## 6. DEVELOPMENT WORKFLOW CHECKLIST
- Server Laravel: `php artisan serve`
- Asset Compiling / Live Reload: `npm run dev` (atau `npm.cmd run dev` di Windows)
- Migrasi Database: `php artisan migrate`
- Background Queue Worker (Watermarking): `php artisan queue:listen`