<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tagihan_user');

        Schema::create('tagihan_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tagihan_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['belum', 'sudah'])->default('belum');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->timestamps();

            $table->unique(['tagihan_id', 'user_id'], 'tagihan_user_unique_assignment');
            $table->index('payment_id', 'tagihan_user_payment_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan_user');
    }
};
