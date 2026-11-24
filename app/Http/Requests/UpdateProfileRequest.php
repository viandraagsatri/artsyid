<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'bio'  => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tampilan wajib diisi.',
            'name.max'      => 'Nama tampilan maksimal 255 karakter.',
            'bio.max'       => 'Bio maksimal 1000 karakter.',
        ];
    }
}
