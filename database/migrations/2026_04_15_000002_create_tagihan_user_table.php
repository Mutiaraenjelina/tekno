<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihan_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tagihan_id');
            $table->bigInteger('user_id');
            $table->enum('status', ['belum', 'sudah'])->default('belum');
            $table->bigInteger('payment_id')->nullable();
            $table->timestamps();

            $table->unique(['tagihan_id', 'user_id'], 'tagihan_user_unique_assignment');
            $table->index('payment_id', 'tagihan_user_payment_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_user');
    }
};
