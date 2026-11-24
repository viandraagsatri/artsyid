<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderRevision extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'track_id',
        'revision_notes',
        'status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(OrderTrack::class, 'track_id');
    }
}
