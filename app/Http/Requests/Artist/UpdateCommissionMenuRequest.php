<?php

namespace App\Http\Requests\Artist;

use App\Models\CommissionMenu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommissionMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        $menu = $this->route('menu');

        return $user?->role === 'artist'
            && $menu instanceof CommissionMenu
            && (int) $menu->artist_id === (int) $user->id;
    }

    protected function prepareForValidation(): void
    {
        $title = $this->input('title');
        $description = $this->input('description');

        $this->merge([
            'title' => is_scalar($title) ? trim((string) $title) : $title,
            'description' => is_scalar($description) ? trim((string) $description) : $description,
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:150'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:10', 'max:3000'],
            'base_price' => ['required', 'integer', 'min:10000', 'max:999999999'],
            'dp_percentage' => ['required', 'integer', 'min:10', 'max:100'],
            'estimated_days' => ['required', 'integer', 'min:1', 'max:365'],
            'max_revision' => ['required', 'integer', 'min:0', 'max:20'],
            'available_slots' => ['required', 'integer', 'min:0', 'max:100'],
            'request_type' => ['required', 'string', Rule::in(['custom', 'instant'])],
            'is_active' => ['boolean'],
            'samples' => ['nullable', 'array', 'max:5'],
            'samples.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_sample_ids' => ['nullable', 'array'],
            'remove_sample_ids.*' => ['integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Nama paket komisi wajib diisi.',
            'title.min' => 'Nama paket minimal 3 karakter.',
            'title.max' => 'Nama paket maksimal 150 karakter.',
            'category_id.required' => 'Kategori seni wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'description.required' => 'Deskripsi & ketentuan paket wajib diisi.',
            'description.min' => 'Deskripsi paket minimal 10 karakter.',
            'description.max' => 'Deskripsi paket maksimal 3000 karakter.',
            'base_price.required' => 'Harga dasar wajib diisi.',
            'base_price.integer' => 'Harga dasar harus berupa bilangan bulat Rupiah tanpa desimal.',
            'base_price.min' => 'Harga dasar minimal Rp 10.000.',
            'base_price.max' => 'Harga dasar melebihi batas maksimum.',
            'dp_percentage.required' => 'Persentase DP wajib diisi.',
            'dp_percentage.integer' => 'Persentase DP harus berupa bilangan bulat.',
            'dp_percentage.min' => 'Persentase DP minimal 10%.',
            'dp_percentage.max' => 'Persentase DP maksimal 100%.',
            'estimated_days.required' => 'Estimasi pengerjaan wajib diisi.',
            'estimated_days.integer' => 'Estimasi pengerjaan harus berupa bilangan bulat.',
            'estimated_days.min' => 'Estimasi pengerjaan minimal 1 hari.',
            'estimated_days.max' => 'Estimasi pengerjaan maksimal 365 hari.',
            'max_revision.required' => 'Kuota revisi wajib diisi.',
            'max_revision.integer' => 'Kuota revisi harus berupa bilangan bulat.',
            'max_revision.min' => 'Kuota revisi minimal 0.',
            'max_revision.max' => 'Kuota revisi maksimal 20.',
            'available_slots.required' => 'Jumlah slot tersedia wajib diisi.',
            'available_slots.integer' => 'Jumlah slot harus berupa bilangan bulat.',
            'available_slots.min' => 'Jumlah slot minimal 0.',
            'available_slots.max' => 'Jumlah slot maksimal 100.',
            'request_type.required' => 'Tipe pemesanan wajib dipilih.',
            'request_type.in' => 'Tipe pemesanan harus Custom atau Instant.',
            'samples.array' => 'Format unggahan sampel gambar tidak valid.',
            'samples.max' => 'Maksimal 5 sampel gambar yang dapat diunggah sekaligus.',
            'samples.*.image' => 'Setiap file sampel harus berupa gambar yang valid.',
            'samples.*.mimes' => 'Format sampel gambar yang diizinkan hanya JPG, JPEG, PNG, atau WEBP.',
            'samples.*.max' => 'Ukuran setiap file sampel maksimal 3 MB.',
            'remove_sample_ids.array' => 'Pilihan penghapusan sampel tidak valid.',
            'remove_sample_ids.*.integer' => 'Identitas sampel gambar tidak valid.',
        ];
    }
}
