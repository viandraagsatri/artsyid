<div class="space-y-6">
    <!-- Informasi Utama Paket -->
    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-5">
        <div class="border-b border-stone-100 pb-3">
            <h2 class="text-base font-bold font-heading text-slate-dark">Informasi Utama Paket</h2>
            <p class="text-xs text-slate-muted mt-0.5">Tentukan nama layanan dan kategori seni yang paling sesuai.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="title" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Nama Paket / Menu <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    required
                    maxlength="150"
                    value="{{ $form['title'] }}"
                    placeholder="Contoh: Half-Body Ilustrasi Pastel"
                    aria-invalid="{{ $errors->has('title') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('title') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                >
                @error('title')
                    <p class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Kategori Seni <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <select
                    id="category_id"
                    name="category_id"
                    required
                    aria-invalid="{{ $errors->has('category_id') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('category_id') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition cursor-pointer"
                >
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $form['category_id'] === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                Deskripsi &amp; Ketentuan Paket <span class="text-red-600" aria-hidden="true">*</span>
            </label>
            <textarea
                id="description"
                name="description"
                rows="4"
                required
                maxlength="3000"
                placeholder="Jelaskan ukuran kanvas, gaya pewarnaan, apa saja yang diterima client (PNG/PSD), serta hal yang tidak diterima..."
                aria-invalid="{{ $errors->has('description') ? 'true' : 'false' }}"
                class="w-full rounded-xl border {{ $errors->has('description') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-3 text-sm text-slate-dark placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
            >{{ $form['description'] }}</textarea>
            @error('description')
                <p class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Harga, Skema Escrow DP & Kapasitas Pengerjaan -->
    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-5">
        <div class="border-b border-stone-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-base font-bold font-heading text-slate-dark">Harga, Escrow DP &amp; Kapasitas</h2>
                <p class="text-xs text-slate-muted mt-0.5">Dana DP dan pelunasan ditahan aman di Escrow hingga karya selesai.</p>
            </div>
            <div id="dp-preview-pill" class="inline-flex flex-wrap items-center gap-2 px-3.5 py-2 rounded-xl bg-pastel-100 border border-pastel-300 text-xs font-bold text-slate-dark">
                <i class="fa-solid fa-shield-halved text-amber-700" aria-hidden="true"></i>
                <span id="dp-preview-text">Estimasi DP: Rp 0 | Pelunasan: Rp 0</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="base_price" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Harga Dasar (Rp) <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <input
                    type="number"
                    id="base_price"
                    name="base_price"
                    required
                    min="10000"
                    step="1"
                    value="{{ $form['base_price'] }}"
                    placeholder="Contoh: 450000"
                    aria-invalid="{{ $errors->has('base_price') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('base_price') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark tabular-nums placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                >
                <p class="mt-1 text-[11px] text-slate-muted">Minimal Rp 10.000 (belum termasuk add-ons opsional).</p>
                @error('base_price')
                    <p class="mt-1 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="dp_percentage" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Persentase DP (%) <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <input
                    type="number"
                    id="dp_percentage"
                    name="dp_percentage"
                    required
                    min="10"
                    max="100"
                    step="1"
                    value="{{ $form['dp_percentage'] }}"
                    placeholder="Contoh: 50"
                    aria-invalid="{{ $errors->has('dp_percentage') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('dp_percentage') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark tabular-nums placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                >
                <p class="mt-1 text-[11px] text-slate-muted">Standar Artsy ID adalah 50% (rentang diizinkan: 10% s.d. 100%).</p>
                @error('dp_percentage')
                    <p class="mt-1 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
                <label for="estimated_days" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Estimasi Pengerjaan (Hari) <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <input
                    type="number"
                    id="estimated_days"
                    name="estimated_days"
                    required
                    min="1"
                    max="365"
                    value="{{ $form['estimated_days'] }}"
                    placeholder="Contoh: 7"
                    aria-invalid="{{ $errors->has('estimated_days') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('estimated_days') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark tabular-nums placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                >
                @error('estimated_days')
                    <p class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="max_revision" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Maks. Kuota Revisi (Total Pesanan) <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <input
                    type="number"
                    id="max_revision"
                    name="max_revision"
                    required
                    min="0"
                    max="20"
                    value="{{ $form['max_revision'] }}"
                    placeholder="Contoh: 2"
                    aria-invalid="{{ $errors->has('max_revision') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('max_revision') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark tabular-nums placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                >
                <p class="mt-1 text-[11px] text-slate-muted">Kuota akumulatif seluruh tahap (Sketsa s.d. Rendering).</p>
                @error('max_revision')
                    <p class="mt-1 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="available_slots" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Slot Tersedia <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <input
                    type="number"
                    id="available_slots"
                    name="available_slots"
                    required
                    min="0"
                    max="100"
                    value="{{ $form['available_slots'] }}"
                    placeholder="Contoh: 3"
                    aria-invalid="{{ $errors->has('available_slots') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('available_slots') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark tabular-nums placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                >
                <p class="mt-1 text-[11px] text-slate-muted">Isi 0 jika slot sementara penuh tanpa menutup etalase.</p>
                @error('available_slots')
                    <p class="mt-1 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start pt-1">
            <div>
                <label for="request_type" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                    Tipe Pemesanan <span class="text-red-600" aria-hidden="true">*</span>
                </label>
                <select
                    id="request_type"
                    name="request_type"
                    required
                    aria-invalid="{{ $errors->has('request_type') ? 'true' : 'false' }}"
                    class="w-full min-h-11 rounded-xl border {{ $errors->has('request_type') ? 'border-red-400 bg-red-50/40' : 'border-stone-300 bg-bg-light' }} px-4 py-2.5 text-sm text-slate-dark focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition cursor-pointer"
                >
                    <option value="custom" {{ $form['request_type'] === 'custom' ? 'selected' : '' }}>Custom (Tinjau &amp; Setujui Request Dulu)</option>
                    <option value="instant" {{ $form['request_type'] === 'instant' ? 'selected' : '' }}>Instant (Otomatis Terbit Invoice DP)</option>
                </select>
                <p class="mt-1 text-[11px] text-slate-muted">Custom memberi Anda waktu mengecek brief client sebelum order diterima.</p>
                @error('request_type')
                    <p class="mt-1 text-xs font-medium text-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl border border-stone-200 bg-bg-light px-4 py-3.5 flex items-center justify-between gap-4 mt-0 md:mt-7">
                <div class="min-w-0">
                    <label for="is_active" class="text-sm font-semibold font-heading text-slate-dark cursor-pointer block">
                        Tampilkan di Etalase Publik
                    </label>
                    <p class="text-[11px] text-slate-muted mt-0.5">
                        Saat aktif, paket tampil di katalog dan dapat dipesan jika slot &gt; 0.
                    </p>
                </div>
                <input type="hidden" name="is_active" value="0">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ $form['is_active'] ? 'checked' : '' }}
                    class="w-5 h-5 accent-slate-dark rounded cursor-pointer shrink-0"
                >
            </div>
        </div>
    </div>

    <!-- Sampel Gambar Menu Komisi -->
    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-5">
        <div class="border-b border-stone-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h2 class="text-base font-bold font-heading text-slate-dark">Sampel Gambar Paket</h2>
                <p class="text-xs text-slate-muted mt-0.5">
                    Unggah contoh hasil karya khusus paket ini (maksimal {{ $form['max_samples'] }} gambar, format JPG/PNG/WEBP, maks. 3 MB/file).
                </p>
            </div>
            <span id="sample-slot-counter"
                data-existing-count="{{ count($form['existing_samples']) }}"
                data-max-samples="{{ $form['max_samples'] }}"
                class="inline-flex items-center px-3 py-1.5 rounded-full bg-stone-100 text-xs font-bold text-slate-dark tabular-nums self-start sm:self-auto">
                {{ count($form['existing_samples']) }} / {{ $form['max_samples'] }} sampel tersimpan
            </span>
        </div>

        @if ($form['is_edit'] && count($form['existing_samples']) > 0)
            <div class="space-y-2.5">
                <p class="text-xs font-semibold font-heading text-slate-dark">
                    Sampel Tersimpan Saat Ini (centang jika ingin dihapus saat menyimpan perubahan):
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                    @foreach ($form['existing_samples'] as $sample)
                        <label
                            for="remove-sample-{{ $sample['id'] }}"
                            class="sample-existing-card group rounded-xl border p-2.5 transition cursor-pointer flex items-center gap-3 {{ $sample['is_marked_remove'] ? 'border-red-300 bg-red-50/70' : 'border-stone-200 bg-bg-light hover:border-stone-300' }}"
                        >
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-stone-100 border border-stone-200 shrink-0 flex items-center justify-center">
                                @if ($sample['safe_url'])
                                    <img src="{{ $sample['safe_url'] }}" alt="Sampel menu {{ $sample['number'] }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-regular fa-image text-slate-muted" aria-hidden="true"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sample['is_local_upload'] ? 'bg-pastel-100 text-amber-900 border border-pastel-300' : 'bg-status-info-bg text-status-info-text border border-status-info-border' }}">
                                    {{ $sample['is_local_upload'] ? 'File Unggahan' : 'URL Sampel' }}
                                </span>
                                <span class="block text-xs font-semibold text-slate-dark">
                                    Sampel #{{ $sample['number'] }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-red-700">
                                    <input
                                        type="checkbox"
                                        id="remove-sample-{{ $sample['id'] }}"
                                        name="remove_sample_ids[]"
                                        value="{{ $sample['id'] }}"
                                        {{ $sample['is_marked_remove'] ? 'checked' : '' }}
                                        class="sample-remove-checkbox w-4 h-4 accent-red-600 rounded cursor-pointer"
                                    >
                                    <span>Hapus saat simpan</span>
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label for="samples" class="block text-sm font-semibold font-heading text-slate-dark mb-1.5">
                {{ $form['is_edit'] ? 'Tambah Sampel Gambar Baru (Opsional)' : 'Unggah Sampel Gambar (Opsional)' }}
            </label>
            <input
                type="file"
                id="samples"
                name="samples[]"
                accept="image/jpeg,image/png,image/webp"
                multiple
                class="block w-full text-xs sm:text-sm text-slate-body file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border file:border-pastel-300 file:text-xs file:font-bold file:font-heading file:bg-pastel-100 file:text-slate-dark hover:file:bg-pastel-200 file:cursor-pointer rounded-xl border border-dashed border-stone-300 bg-bg-light p-3 transition cursor-pointer"
            >
            <p class="mt-1.5 text-[11px] text-slate-muted">
                Anda dapat memilih beberapa file sekaligus (Ctrl/Shift + klik). Format: JPG, PNG, WEBP, maksimal 3 MB per gambar.
            </p>
            @error('samples')
                <p class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>
            @enderror
            @if ($errors->has('samples.*'))
                @foreach ($errors->get('samples.*') as $sampleErrorMessages)
                    @foreach ($sampleErrorMessages as $sampleErrorMessage)
                        <p class="mt-1 text-xs font-medium text-red-700">{{ $sampleErrorMessage }}</p>
                    @endforeach
                @endforeach
            @endif

            <p id="samples-client-warning"
                role="alert"
                class="hidden mt-2 text-xs font-semibold text-status-danger-text bg-status-danger-bg border border-status-danger-border rounded-xl px-3.5 py-2.5"></p>

            <div id="samples-new-preview-wrap" class="hidden mt-4 space-y-2">
                <p class="text-xs font-semibold font-heading text-slate-dark">Pratinjau file yang akan diunggah:</p>
                <div id="samples-new-preview-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3"></div>
            </div>
        </div>
    </div>

    <!-- Aksi Submit -->
    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 sm:p-5 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3">
        <p class="text-xs text-slate-muted">
            Add-ons paket dapat dikelola kapan saja melalui tombol <strong class="text-slate-dark">Kelola Add-ons</strong> di halaman daftar paket.
        </p>
        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
            <a href="{{ route('artist.menus.index') }}" class="btn-secondary min-h-11 sm:min-h-0 text-xs sm:text-sm cursor-pointer">
                Batal
            </a>
            <button type="submit" class="btn-primary min-h-11 sm:min-h-0 text-xs sm:text-sm cursor-pointer gap-2">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span>{{ $form['is_edit'] ? 'Simpan Perubahan Paket' : 'Simpan Menu Katalog' }}</span>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const basePriceInput = document.getElementById('base_price');
        const dpPercentInput = document.getElementById('dp_percentage');
        const dpPreviewText = document.getElementById('dp-preview-text');

        function formatRupiah(amount) {
            return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
        }

        function updateDpPreview() {
            if (!basePriceInput || !dpPercentInput || !dpPreviewText) return;
            const base = Math.max(0, Number(basePriceInput.value) || 0);
            const pct = Math.min(100, Math.max(0, Number(dpPercentInput.value) || 0));
            const dpAmount = (base * pct) / 100;
            const finalAmount = Math.max(0, base - dpAmount);
            dpPreviewText.textContent = 'Estimasi DP (' + pct + '%): ' + formatRupiah(dpAmount) + ' | Pelunasan: ' + formatRupiah(finalAmount);
        }

        if (basePriceInput && dpPercentInput) {
            basePriceInput.addEventListener('input', updateDpPreview);
            dpPercentInput.addEventListener('input', updateDpPreview);
            updateDpPreview();
        }

        const sampleInput = document.getElementById('samples');
        const previewWrap = document.getElementById('samples-new-preview-wrap');
        const previewGrid = document.getElementById('samples-new-preview-grid');
        const sampleCounter = document.getElementById('sample-slot-counter');
        const sampleClientWarning = document.getElementById('samples-client-warning');
        const removeCheckboxes = document.querySelectorAll('.sample-remove-checkbox');

        const existingCount = sampleCounter ? Number(sampleCounter.getAttribute('data-existing-count') || 0) : 0;
        const maxSamples = sampleCounter ? Number(sampleCounter.getAttribute('data-max-samples') || 5) : 5;
        const allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxFileSizeBytes = 3 * 1024 * 1024;
        let activeObjectUrls = [];

        function clearPreviews() {
            activeObjectUrls.forEach(function (url) {
                URL.revokeObjectURL(url);
            });
            activeObjectUrls = [];
            if (previewGrid) {
                while (previewGrid.firstChild) {
                    previewGrid.removeChild(previewGrid.firstChild);
                }
            }
        }

        function updateSampleQuotaAndWarnings() {
            let checkedRemoveCount = 0;
            removeCheckboxes.forEach(function (cb) {
                if (cb.checked) checkedRemoveCount += 1;
            });

            const keptExisting = Math.max(0, existingCount - checkedRemoveCount);
            const files = sampleInput ? Array.from(sampleInput.files || []) : [];
            const projectedTotal = keptExisting + files.length;

            if (sampleCounter) {
                sampleCounter.textContent = files.length > 0 || checkedRemoveCount > 0
                    ? projectedTotal + ' / ' + maxSamples + ' total sampel (tersimpan: ' + keptExisting + ', baru: ' + files.length + ')'
                    : existingCount + ' / ' + maxSamples + ' sampel tersimpan';

                if (projectedTotal > maxSamples) {
                    sampleCounter.classList.remove('bg-stone-100', 'text-slate-dark');
                    sampleCounter.classList.add('bg-status-danger-bg', 'text-status-danger-text');
                } else {
                    sampleCounter.classList.remove('bg-status-danger-bg', 'text-status-danger-text');
                    sampleCounter.classList.add('bg-stone-100', 'text-slate-dark');
                }
            }

            if (sampleClientWarning) {
                const warnings = [];
                if (projectedTotal > maxSamples) {
                    warnings.push('Total sampel (' + projectedTotal + ') melebihi batas maksimal ' + maxSamples + ' gambar. Kurangi file baru atau centang hapus pada sampel lama.');
                }

                const invalidFormatNames = [];
                const oversizedNames = [];
                files.forEach(function (file) {
                    if (!allowedMimeTypes.includes(file.type)) {
                        invalidFormatNames.push(file.name);
                    }
                    if (file.size > maxFileSizeBytes) {
                        oversizedNames.push(file.name);
                    }
                });

                if (invalidFormatNames.length > 0) {
                    warnings.push('Format tidak didukung (wajib JPG/PNG/WEBP): ' + invalidFormatNames.join(', ') + '.');
                }
                if (oversizedNames.length > 0) {
                    warnings.push('Ukuran melebihi 3 MB: ' + oversizedNames.join(', ') + '.');
                }

                if (warnings.length > 0) {
                    sampleClientWarning.textContent = warnings.join(' ');
                    sampleClientWarning.classList.remove('hidden');
                } else {
                    sampleClientWarning.textContent = '';
                    sampleClientWarning.classList.add('hidden');
                }
            }
        }

        if (sampleInput && previewWrap && previewGrid) {
            sampleInput.addEventListener('change', function () {
                clearPreviews();
                updateSampleQuotaAndWarnings();

                const files = Array.from(sampleInput.files || []);
                if (files.length === 0) {
                    previewWrap.classList.add('hidden');
                    return;
                }

                previewWrap.classList.remove('hidden');

                files.forEach(function (file) {
                    const isValidType = allowedMimeTypes.includes(file.type);
                    const isValidSize = file.size <= maxFileSizeBytes;

                    const card = document.createElement('div');
                    card.className = 'rounded-xl border p-2 space-y-1.5 ' + (isValidType && isValidSize ? 'border-stone-200 bg-bg-light' : 'border-red-300 bg-red-50/70');

                    const thumbBox = document.createElement('div');
                    thumbBox.className = 'aspect-4/3 w-full rounded-lg overflow-hidden bg-stone-100 flex items-center justify-center';

                    if (isValidType) {
                        const img = document.createElement('img');
                        const objUrl = URL.createObjectURL(file);
                        activeObjectUrls.push(objUrl);
                        img.src = objUrl;
                        img.alt = file.name;
                        img.className = 'w-full h-full object-cover';
                        thumbBox.appendChild(img);
                    } else {
                        const icon = document.createElement('i');
                        icon.className = 'fa-solid fa-file-circle-exclamation text-xl text-status-danger-text';
                        icon.setAttribute('aria-hidden', 'true');
                        thumbBox.appendChild(icon);
                    }

                    const caption = document.createElement('p');
                    caption.className = 'text-[11px] font-medium truncate ' + (isValidType && isValidSize ? 'text-slate-body' : 'text-status-danger-text');
                    caption.textContent = file.name;

                    card.appendChild(thumbBox);
                    card.appendChild(caption);
                    previewGrid.appendChild(card);
                });
            });
        }

        removeCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const parentCard = checkbox.closest('.sample-existing-card');
                if (parentCard) {
                    if (checkbox.checked) {
                        parentCard.classList.remove('border-stone-200', 'bg-bg-light', 'hover:border-stone-300');
                        parentCard.classList.add('border-red-300', 'bg-red-50/70');
                    } else {
                        parentCard.classList.remove('border-red-300', 'bg-red-50/70');
                        parentCard.classList.add('border-stone-200', 'bg-bg-light', 'hover:border-stone-300');
                    }
                }
                updateSampleQuotaAndWarnings();
            });
        });

        updateSampleQuotaAndWarnings();
    });
</script>
