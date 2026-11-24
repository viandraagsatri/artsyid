<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'in:user,admin'],
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in'       => 'Role hanya dapat diubah antara Client (user) dan Administrator (admin).',
        ];
    }
}
