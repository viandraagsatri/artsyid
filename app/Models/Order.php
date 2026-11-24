<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'client_id',
        'artist_id',
        'commission_menu_id',
        'concept_description',
        'vibes',
        'background_type',
        'character_count',
        'request_type',
        'status',
        'rejection_reason',
        'base_amount',
        'addons_amount',
        'total_amount',
        'dp_amount',
        'final_amount',
        'deadline_at',
    ];

    protected function casts(): array
    {
        return [
            'character_count' => 'integer',
            'base_amount' => 'decimal:2',
            'addons_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'dp_amount' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'deadline_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function commissionMenu(): BelongsTo
    {
        return $this->belongsTo(CommissionMenu::class);
    }

    public function addons(): HasMany
    {
        return $this->hasMany(OrderAddon::class);
    }

    public function references(): HasMany
    {
        return $this->hasMany(OrderReference::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(OrderTrack::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(OrderRevision::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(OrderChat::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ArtistReport::class);
    }
}
