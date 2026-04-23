<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = ['id'];
    public $timestamps = true;

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the tagihan for this transaction
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }

    /**
     * Get the user who made this transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all tagihan_user records linked to this transaction
     */
    public function tagihanUsers(): HasMany
    {
        return $this->hasMany(TagihanUser::class, 'payment_id');
    }
}
