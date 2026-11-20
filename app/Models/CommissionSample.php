<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissionSample extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'commission_menu_id',
        'image_url',
    ];

    public function commissionMenu(): BelongsTo
    {
        return $this->belongsTo(CommissionMenu::class);
    }
}
