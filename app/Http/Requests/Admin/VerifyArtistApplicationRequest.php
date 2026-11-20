<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VerifyArtistApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action'      => ['required', 'in:approve,reject'],
            'admin_notes' => ['nullable', 'string', 'max:1000', 'required_if:action,reject'],
        ];
    }

    public function messages(): array
    {
        return [
            'action.required'         => 'Aksi verifikasi harus ditentukan.',
            'action.in'               => 'Aksi verifikasi tidak valid.',
            'admin_notes.required_if' => 'Alasan penolakan wajib diisi jika menolak pengajuan.',
            'admin_notes.max'         => 'Catatan admin maksimal 1000 karakter.',
        ];
    }
}
