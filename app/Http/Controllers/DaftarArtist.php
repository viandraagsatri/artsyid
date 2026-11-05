<?php

namespace App\Http\Controllers;

use App\Models\ArtistApplication;
use App\Models\ArtistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaftarArtist extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'artist') {
            return redirect()->route('dashboard')->with('success', 'Kamu sudah terdaftar sebagai artist.');
        }

        $hasPending = $this->hasPendingApplication($user->id);

        return view('daftar_artist', compact('hasPending'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'         => ['required', 'string', 'max:100'],
            'account_number'    => ['required', 'regex:/^[0-9]{6,25}$/'],
            'account_holder'    => ['required', 'string', 'max:255'],
            'tos_bisa'          => ['required', 'string', 'max:2000'],
            'tos_tidak'         => ['required', 'string', 'max:2000'],
            'portfolio_links'   => ['required', 'array', 'min:1', 'max:5'],
            'portfolio_links.*' => ['required', 'url:http,https', 'max:255', 'distinct'],
        ], [
            'required'                   => ':attribute wajib diisi.',
            'max'                        => ':attribute terlalu panjang.',
            'account_number.regex'       => 'Nomor rekening hanya boleh angka (6-25 digit).',
            'portfolio_links.min'        => 'Isi minimal satu link portofolio.',
            'portfolio_links.max'        => 'Maksimal 5 link portofolio.',
            'portfolio_links.*.url'      => 'Link harus diawali http:// atau https://.',
            'portfolio_links.*.distinct' => 'Ada link portofolio yang sama, hapus salah satunya.',
        ], [
            'bank_name'         => 'Nama bank',
            'account_number'    => 'Nomor rekening',
            'account_holder'    => 'Nama pemilik rekening',
            'tos_bisa'          => 'Daftar "Bisa Digambar"',
            'tos_tidak'         => 'Daftar "Tidak Menerima"',
            'portfolio_links'   => 'Link portofolio',
            'portfolio_links.*' => 'Link portofolio',
        ]);

        $user = Auth::user();

        if ($user->role === 'artist' || $this->hasPendingApplication($user->id)) {
            return redirect()->route('register.artist');
        }

        DB::transaction(function () use ($request, $user) {
            ArtistProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bank_name'      => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_holder' => $request->account_holder,
                    'tos'            => [
                        'bisa_digambar'  => $this->toLines($request->tos_bisa),
                        'tidak_menerima' => $this->toLines($request->tos_tidak),
                    ],
                ]
            );

            foreach ($request->portfolio_links as $link) {
                ArtistApplication::create([
                    'user_id'               => $user->id,
                    'verification_file_url' => $link,
                ]);
            }
        });

        return redirect()->route('register.artist')
            ->with('success', 'Pengajuan terkirim! Admin akan memverifikasi portofolio kamu.');
    }

    private function hasPendingApplication(int $userId): bool
    {
        return ArtistApplication::where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }

    private function toLines(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', $text))));
    }
}