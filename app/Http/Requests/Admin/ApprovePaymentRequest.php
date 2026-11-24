<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApprovePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'audit_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'audit_notes.string' => 'Catatan audit harus berupa teks.',
            'audit_notes.max'    => 'Catatan audit maksimal 1000 karakter.',
        ];
    }
}
