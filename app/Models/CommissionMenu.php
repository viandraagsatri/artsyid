<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CommissionMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'category_id',
        'title',
        'description',
        'base_price',
        'estimated_days',
        'max_revision',
        'dp_percentage',
        'available_slots',
        'request_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'dp_percentage' => 'decimal:2',
            'estimated_days' => 'integer',
            'max_revision' => 'integer',
            'available_slots' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function samples(): HasMany
    {
        return $this->hasMany(CommissionSample::class);
    }

    public function addons(): HasMany
    {
        return $this->hasMany(CommissionAddon::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            Order::class,
            'commission_menu_id',
            'order_id',
            'id',
            'id'
        );
    }
}
