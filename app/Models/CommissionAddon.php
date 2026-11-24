<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommissionAddon extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'commission_menu_id',
        'title',
        'description',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function commissionMenu(): BelongsTo
    {
        return $this->belongsTo(CommissionMenu::class);
    }

    public function orderAddons(): HasMany
    {
        return $this->hasMany(OrderAddon::class, 'addon_id');
    }
}
