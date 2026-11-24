<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bank_name'         => ['required', 'string', 'max:100'],
            'account_number'    => ['required', 'regex:/^[0-9]{6,25}$/'],
            'account_holder'    => ['required', 'string', 'max:255'],
            'tos_bisa'          => ['required', 'string', 'max:2000'],
            'tos_tidak'         => ['required', 'string', 'max:2000'],
            'portfolio_links'   => ['required', 'array', 'min:1', 'max:5'],
            'portfolio_links.*' => ['required', 'url:http,https', 'max:255', 'distinct'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'                   => ':attribute wajib diisi.',
            'max'                        => ':attribute terlalu panjang.',
            'account_number.regex'       => 'Nomor rekening hanya boleh angka (6-25 digit).',
            'portfolio_links.min'        => 'Isi minimal satu link portofolio.',
            'portfolio_links.max'        => 'Maksimal 5 link portofolio.',
            'portfolio_links.*.url'      => 'Link harus diawali http:// atau https://.',
            'portfolio_links.*.distinct' => 'Ada link portofolio yang sama, hapus salah satunya.',
        ];
    }

    public function attributes(): array
    {
        return [
            'bank_name'         => 'Nama bank',
            'account_number'    => 'Nomor rekening',
            'account_holder'    => 'Nama pemilik rekening',
            'tos_bisa'          => 'Daftar "Bisa Digambar"',
            'tos_tidak'         => 'Daftar "Tidak Menerima"',
            'portfolio_links'   => 'Link portofolio',
            'portfolio_links.*' => 'Link portofolio',
        ];
    }
}
