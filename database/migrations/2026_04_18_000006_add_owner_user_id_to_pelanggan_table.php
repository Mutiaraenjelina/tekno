<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->foreignId('owner_user_id')
                ->nullable()
                ->after('no_wa')
                ->constrained('users')
                ->nullOnDelete();
        });

        $pelangganRows = DB::table('pelanggan')->select('id')->get();

        foreach ($pelangganRows as $pelanggan) {
            $ownerUserId = DB::table('tagihan_user as tu')
                ->join('tagihan as t', 't.id', '=', 'tu.tagihan_id')
                ->join('users as u', 'u.id', '=', 'tu.user_id')
                ->where('u.idPersonal', $pelanggan->id)
                ->groupBy('t.created_by')
                ->orderByRaw('COUNT(*) DESC')
                ->value('t.created_by');

            if ($ownerUserId) {
                DB::table('pelanggan')
                    ->where('id', $pelanggan->id)
                    ->update(['owner_user_id' => $ownerUserId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('owner_user_id');
        });
    }
};
