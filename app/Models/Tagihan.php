<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $guarded = ['id'];
    public $timestamps = true;

    protected $casts = [
        'jatuh_tempo' => 'date',
        'nominal' => 'decimal:2',
    ];

    /**
     * Get the user who created this tagihan
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all tagihan_user records for this tagihan
     */
    public function tagihanUsers(): HasMany
    {
        return $this->hasMany(TagihanUser::class, 'tagihan_id');
    }

    /**
     * Get all transaksi for this tagihan
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'tagihan_id');
    }
}
