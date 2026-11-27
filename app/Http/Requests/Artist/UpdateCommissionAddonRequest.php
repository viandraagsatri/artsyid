<?php

namespace App\Http\Requests\Artist;

use App\Models\CommissionMenu;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommissionAddonRequest extends FormRequest
{
    protected $errorBag = 'addonUpdate';

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

        if (is_scalar($description)) {
            $trimmedDescription = trim((string) $description);
            $normalizedDescription = $trimmedDescription !== '' ? $trimmedDescription : null;
        } else {
            $normalizedDescription = $description;
        }

        $this->merge([
            'title' => is_scalar($title) ? trim((string) $title) : $title,
            'description' => $normalizedDescription,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'integer', 'min:1000', 'max:999999999'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Nama add-on wajib diisi.',
            'title.min' => 'Nama add-on minimal 2 karakter.',
            'title.max' => 'Nama add-on maksimal 120 karakter.',
            'description.max' => 'Deskripsi add-on maksimal 500 karakter.',
            'price.required' => 'Harga tambahan add-on wajib diisi.',
            'price.integer' => 'Harga tambahan harus berupa bilangan bulat Rupiah tanpa desimal.',
            'price.min' => 'Harga tambahan minimal Rp 1.000.',
            'price.max' => 'Harga tambahan melebihi batas maksimum.',
        ];
    }
}
