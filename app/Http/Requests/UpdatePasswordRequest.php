<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required'         => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama yang kamu masukkan salah.',
            'password.required'                 => 'Password baru wajib diisi.',
            'password.confirmed'                => 'Password baru dan konfirmasi tidak cocok.',
            'password.min'                      => 'Password baru minimal 8 karakter.',
        ];
    }
}
