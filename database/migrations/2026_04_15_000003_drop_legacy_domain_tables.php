<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $legacyTables = [
            'approvalby', 'biaya', 'bidang', 'detailbuktipembayaran', 'dokumenkelengkapan',
            'dokumenpermohonansewa', 'golonganpangkat', 'headbuktipembayaran', 'jabatan',
            'jabatanbidang', 'jangkawaktusewa', 'jenisapproval', 'jenisbiaya', 'jenisdokumen',
            'jenisjangkawaktu', 'jeniskegiatan', 'jenisobjekretribusi', 'jenispermohonan',
            'jenisretribusi', 'jenissatuan', 'jenisstatus', 'jenisuser', 'jeniswajibretribusi',
            'lokasiobjekretribusi', 'manywajibretribusi', 'objekretribusi', 'pegawai', 'pekerjaan',
            'pembayaranretribusi', 'pembayaransewa', 'pembayaransewadetail', 'penugasanapproval',
            'perjanjiansewa', 'permissions', 'permohonansewa', 'peruntukansewa', 'photoobjekretribusi',
            'roles', 'saksiperjanjiansewa', 'satuan', 'status', 'tagihansewa', 'tarifobjekretribusi',
            'wajibretribusi'
        ];

        foreach ($legacyTables as $table) {
            Schema::dropIfExists($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        // Legacy tables intentionally not recreated.
    }
};
