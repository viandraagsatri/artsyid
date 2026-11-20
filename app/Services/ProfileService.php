<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function updateProfile(User $user, array $data): bool
    {
        return $user->update([
            'name' => $data['name'],
            'bio'  => $data['bio'] ?? null,
        ]);
    }

    public function updatePassword(User $user, string $newPassword): bool
    {
        return $user->update([
            'password' => Hash::make($newPassword),
        ]);
    }
}
