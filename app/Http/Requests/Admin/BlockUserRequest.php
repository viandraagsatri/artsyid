<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlockUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'block_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'block_reason.required' => 'Alasan pemblokiran wajib diisi.',
            'block_reason.string'   => 'Alasan pemblokiran harus berupa teks.',
            'block_reason.min'      => 'Alasan pemblokiran minimal 5 karakter.',
            'block_reason.max'      => 'Alasan pemblokiran maksimal 1000 karakter.',
        ];
    }
}
