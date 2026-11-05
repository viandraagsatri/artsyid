<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'bank_name',
        'account_number',
        'account_holder',
        'tos',
    ];

    protected function casts(): array
    {
        return [
            'tos' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}