<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'artist_id',
        'order_id',
        'reason',
        'description',
        'evidence_file_url',
        'status',
        'admin_notes',
        'handled_by_admin_id',
        'handled_at',
    ];

    protected function casts(): array
    {
        return [
            'handled_at' => 'datetime',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function handledByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by_admin_id');
    }
}
