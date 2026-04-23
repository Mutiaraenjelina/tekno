<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\TagihanUser;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat sample pelanggan terlebih dahulu agar idPersonal user bisa mengarah ke pelanggan.id
        $pelanggan1 = Pelanggan::updateOrCreate(
            ['no_wa' => '62812345678'],
            ['nama' => 'PT Maju Jaya']
        );

        $pelanggan2 = Pelanggan::updateOrCreate(
            ['no_wa' => '62821987654'],
            ['nama' => 'CV Teknologi Baik']
        );

        // Buat sample users
        $admin = User::updateOrCreate(
            ['email' => 'admin@sipayda.local'],
            [
                'roleId' => 1,
                'idJenisUser' => 1,
                'idPersonal' => $pelanggan1->id,
                'username' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $user1 = User::updateOrCreate(
            ['email' => 'user1@sipayda.local'],
            [
                'roleId' => 3,
                'idJenisUser' => 2,
                'idPersonal' => $pelanggan1->id,
                'username' => 'user1',
                'password' => Hash::make('user123'),
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'user2@sipayda.local'],
            [
                'roleId' => 3,
                'idJenisUser' => 2,
                'idPersonal' => $pelanggan2->id,
                'username' => 'user2',
                'password' => Hash::make('user123'),
            ]
        );

        // Buat sample tagihan
        $tagihan1 = Tagihan::updateOrCreate([
            'nama_tagihan' => 'Tagihan Sewa Ruang April 2026',
            'created_by' => $admin->id,
        ], [
            'deskripsi' => 'Biaya sewa ruang kantor untuk bulan April 2026',
            'nominal' => 5000000,
            'tipe' => 'rutin',
            'jatuh_tempo' => now()->addDays(7)->toDateString(),
        ]);

        $tagihan2 = Tagihan::updateOrCreate([
            'nama_tagihan' => 'Tagihan Listrik April 2026',
            'created_by' => $admin->id,
        ], [
            'deskripsi' => 'Biaya listrik kantor April 2026',
            'nominal' => 2000000,
            'tipe' => 'rutin',
            'jatuh_tempo' => now()->addDays(10)->toDateString(),
        ]);

        $tagihan3 = Tagihan::updateOrCreate([
            'nama_tagihan' => 'Tagihan Iuran Asuransi',
            'created_by' => $admin->id,
        ], [
            'deskripsi' => 'Iuran asuransi karyawan satu kali',
            'nominal' => 10000000,
            'tipe' => 'sekali',
            'jatuh_tempo' => now()->addDays(30)->toDateString(),
        ]);

        // Buat sample tagihan_user (assign tagihan ke user)
        TagihanUser::updateOrCreate([
            'tagihan_id' => $tagihan1->id,
            'user_id' => $user1->id,
        ], [
            'status' => 'belum',
        ]);

        TagihanUser::updateOrCreate([
            'tagihan_id' => $tagihan1->id,
            'user_id' => $user2->id,
        ], [
            'status' => 'belum',
        ]);

        TagihanUser::updateOrCreate([
            'tagihan_id' => $tagihan2->id,
            'user_id' => $user1->id,
        ], [
            'status' => 'belum',
        ]);

        TagihanUser::updateOrCreate([
            'tagihan_id' => $tagihan3->id,
            'user_id' => $user2->id,
        ], [
            'status' => 'belum',
        ]);

        // Buat sample transaksi (simulasi pembayaran)
        $transaksi1 = Transaksi::updateOrCreate([
            'order_id' => 'SEED-ORDER-001',
        ], [
            'status' => 'success',
            'amount' => 5000000,
            'metode' => 'transfer_bank',
            'tagihan_id' => $tagihan1->id,
            'user_id' => $user1->id,
            'snap_token' => 'sample-token-1',
            'payment_url' => 'https://app.sandbox.midtrans.com/snap/v1/web/sample-token-1',
        ]);

        $transaksi2 = Transaksi::updateOrCreate([
            'order_id' => 'SEED-ORDER-002',
        ], [
            'status' => 'pending',
            'amount' => 2000000,
            'metode' => null,
            'tagihan_id' => $tagihan2->id,
            'user_id' => $user2->id,
            'snap_token' => 'sample-token-2',
            'payment_url' => 'https://app.sandbox.midtrans.com/snap/v1/web/sample-token-2',
        ]);

        // Update tagihan_user dengan payment_id untuk yang sudah dibayar
        TagihanUser::where('tagihan_id', $tagihan1->id)
            ->where('user_id', $user1->id)
            ->update(['payment_id' => $transaksi1->id, 'status' => 'sudah']);

        echo "\nDatabase seeding completed successfully.\n";
        echo "   Sample data created:\n";
        echo "   - Users: 1 Admin + 2 Regular Users\n";
        echo "   - Pelanggan: 2\n";
        echo "   - Tagihan: 3\n";
        echo "   - Tagihan-User Assignments: 4\n";
        echo "   - Transaksi: 2 (1 success, 1 pending)\n\n";

    }
}
