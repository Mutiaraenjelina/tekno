<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagihanUser extends Model
{
    protected $table = 'tagihan_user';
    protected $guarded = ['id'];
    public $timestamps = true;

    /**
     * Get the tagihan for this assignment
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }

    /**
     * Get the user for this assignment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the payment/transaksi for this assignment
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'payment_id');
    }
}
