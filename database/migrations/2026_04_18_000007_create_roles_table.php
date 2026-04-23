<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('roleName');
                $table->string('roleCode')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->boolean('isDeleted')->default(false);
            });
        }

        $now = now();

        $defaults = [
            ['id' => 1, 'roleName' => 'Super Admin', 'roleCode' => 'super admin', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null, 'isDeleted' => 0],
            ['id' => 2, 'roleName' => 'Admin', 'roleCode' => 'admin', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null, 'isDeleted' => 0],
            ['id' => 3, 'roleName' => 'User', 'roleCode' => 'user', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null, 'isDeleted' => 0],
        ];

        foreach ($defaults as $role) {
            DB::table('roles')->updateOrInsert(['id' => $role['id']], $role);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
