<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'banner_url',
        'foto_url',
        'role',
        'avatar_url',
        'is_blocked',
        'blocked_at',
        'block_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function artistProfile(): HasOne
    {
        return $this->hasOne(ArtistProfile::class);
    }

    public function artistApplications(): HasMany
    {
        return $this->hasMany(ArtistApplication::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'artist_id');
    }

    public function commissionMenus(): HasMany
    {
        return $this->hasMany(CommissionMenu::class, 'artist_id');
    }

    public function ordersAsClient(): HasMany
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function ordersAsArtist(): HasMany
    {
        return $this->hasMany(Order::class, 'artist_id');
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class, 'artist_id');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'artist_id');
    }

    public function reportsFiled(): HasMany
    {
        return $this->hasMany(ArtistReport::class, 'reporter_id');
    }

    public function reportsAgainst(): HasMany
    {
        return $this->hasMany(ArtistReport::class, 'artist_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
