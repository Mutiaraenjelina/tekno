<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            if (! Schema::hasColumn('pelanggan', 'nama_usaha')) {
                $table->string('nama_usaha')->nullable()->after('no_wa');
            }
            if (! Schema::hasColumn('pelanggan', 'jenis_usaha')) {
                $table->string('jenis_usaha', 100)->nullable()->after('nama_usaha');
            }
            if (! Schema::hasColumn('pelanggan', 'jenis_tagihan')) {
                $table->string('jenis_tagihan', 20)->nullable()->after('jenis_usaha');
            }
            if (! Schema::hasColumn('pelanggan', 'is_umkm_verified')) {
                $table->boolean('is_umkm_verified')->default(false)->after('jenis_tagihan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('pelanggan', 'is_umkm_verified')) {
                $dropColumns[] = 'is_umkm_verified';
            }
            if (Schema::hasColumn('pelanggan', 'jenis_tagihan')) {
                $dropColumns[] = 'jenis_tagihan';
            }
            if (Schema::hasColumn('pelanggan', 'jenis_usaha')) {
                $dropColumns[] = 'jenis_usaha';
            }
            if (Schema::hasColumn('pelanggan', 'nama_usaha')) {
                $dropColumns[] = 'nama_usaha';
            }

            if (! empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
