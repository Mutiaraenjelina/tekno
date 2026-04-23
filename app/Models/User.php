<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'roleId',
        'idJenisUser',
        'idPersonal',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the pelanggan that this user belongs to
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'idPersonal', 'id');
    }

    /**
     * Get all tagihan created by this user
     */
    public function tagihanCreated(): HasMany
    {
        return $this->hasMany(Tagihan::class, 'created_by');
    }

    /**
     * Get all tagihan_user assignments for this user
     */
    public function tagihanUsers(): HasMany
    {
        return $this->hasMany(TagihanUser::class, 'user_id');
    }

    /**
     * Get all transactions for this user
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

    public function getRoleNameAttribute(): string
    {
        return match ((string) $this->roleId) {
            '2' => 'Admin',
            '3' => 'User',
            default => 'Super Admin',
        };
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
