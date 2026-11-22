<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifyArtistApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('admin_notes')) {
            $trimmed = trim((string) $this->input('admin_notes'));
            $this->merge([
                'admin_notes' => $trimmed !== '' ? $trimmed : null,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'action'      => ['required', 'in:approve,reject'],
            'admin_notes' => Rule::when(
                $this->input('action') === 'reject',
                ['required', 'string', 'min:5', 'max:1000'],
                ['nullable', 'string', 'max:1000']
            ),
        ];
    }

    public function messages(): array
    {
        return [
            'action.required'      => 'Aksi verifikasi harus ditentukan.',
            'action.in'            => 'Aksi verifikasi tidak valid.',
            'admin_notes.required' => 'Alasan penolakan wajib diisi jika menolak pengajuan.',
            'admin_notes.min'      => 'Alasan penolakan minimal 5 karakter.',
            'admin_notes.string'   => 'Catatan admin harus berupa teks.',
            'admin_notes.max'      => 'Catatan admin maksimal 1000 karakter.',
        ];
    }
}
