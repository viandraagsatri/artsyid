<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderTrack extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'step_order',
        'stage_name',
        'status',
        'watermarked_image_url',
        'final_file_url',
        'notes',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'step_order' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(OrderRevision::class, 'track_id');
    }
}
