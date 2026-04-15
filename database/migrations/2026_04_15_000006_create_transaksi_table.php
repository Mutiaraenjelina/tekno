<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->decimal('amount', 15, 2);
            $table->string('metode', 50)->nullable();
            $table->unsignedBigInteger('tagihan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('snap_token')->nullable();
            $table->text('payment_url')->nullable();
            $table->timestamps();

            $table->index(['tagihan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
