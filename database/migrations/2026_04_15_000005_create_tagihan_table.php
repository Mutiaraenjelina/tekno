<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tagihan');
            $table->text('deskripsi')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->enum('tipe', ['rutin', 'sekali']);
            $table->date('jatuh_tempo');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
