<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ModulePelangganController extends Controller
{
    public function __construct(private readonly WhatsAppService $whatsAppService)
    {
    }

    private function isSuperAdmin(): bool
    {
        return Auth::check() && (string) Auth::user()->roleId === '1';
    }

    private function pelangganListBaseQuery()
    {
        $query = DB::table('pelanggan as p');

        if (Auth::check() && (string) Auth::user()->roleId === '2') {
            $query->where('p.owner_user_id', Auth::id());
        }

        return $query;
    }

    private function ensureLoginUsersForExistingPelanggan(): void
    {
        $pelangganWithoutLogin = $this->pelangganListBaseQuery()
            ->leftJoin('users as u', function ($join) {
                $join->on('u.idPersonal', '=', 'p.id')
                    ->where('u.roleId', '=', 3);
            })
            ->whereNull('u.id')
            ->select('p.id', 'p.nama')
            ->get();

        foreach ($pelangganWithoutLogin as $pelanggan) {
            $this->createLoginUserForPelanggan((int) $pelanggan->id, (string) $pelanggan->nama);
        }
    }

    public function index()
    {
        $this->ensureLoginUsersForExistingPelanggan();

        $pelangganList = $this->pelangganListBaseQuery()
            ->leftJoin('users as u', function ($join) {
                $join->on('u.idPersonal', '=', 'p.id')
                    ->where('u.roleId', '=', 3);
            })
            ->select(
                'p.id',
                'p.nama',
                'p.no_wa',
                'p.nama_usaha',
                'p.jenis_usaha',
                'p.jenis_tagihan',
                'p.is_umkm_verified',
                'p.created_at',
                'p.updated_at',
                'p.owner_user_id',
                DB::raw('COUNT(u.id) as linked_user_count'),
                DB::raw("GROUP_CONCAT(u.username ORDER BY u.username SEPARATOR ', ') as linked_usernames")
            )
            ->groupBy(
                'p.id',
                'p.nama',
                'p.no_wa',
                'p.nama_usaha',
                'p.jenis_usaha',
                'p.jenis_tagihan',
                'p.is_umkm_verified',
                'p.created_at',
                'p.updated_at',
                'p.owner_user_id'
            )
            ->orderByDesc('p.id')
            ->get();

        return view('admin.TagihanDanPembayaran.ModulePelanggan.index', compact('pelangganList'));
    }

    public function create()
    {
        return view('admin.TagihanDanPembayaran.ModulePelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        DB::beginTransaction();

        try {
            $ownerUserId = (Auth::check() && (string) Auth::user()->roleId === '2') ? Auth::id() : null;

            $id = DB::table('pelanggan')->insertGetId([
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'owner_user_id' => $ownerUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $createdUser = $this->createLoginUserForPelanggan($id, $validated['nama']);

            DB::commit();

            $waResult = $this->whatsAppService->sendLoginCredentials(
                $validated['no_wa'],
                $validated['nama'],
                $createdUser['username'],
                $createdUser['plain_password'],
                route('login')
            );

            return redirect()->route('ModulePelanggan.index')
                ->with('success', 'Pelanggan berhasil dibuat dengan ID: ' . $id . '.')
                ->with('new_pelanggan_account', [
                    'nama' => $validated['nama'],
                    'no_wa' => $validated['no_wa'],
                    'username' => $createdUser['username'],
                    'password' => $createdUser['plain_password'],
                    'wa_auto_sent' => $waResult['success'] ?? false,
                    'wa_auto_message' => $waResult['message'] ?? null,
                    'whatsapp_link' => $this->buildWhatsAppLink(
                        $validated['no_wa'],
                        $validated['nama'],
                        $createdUser['username'],
                        $createdUser['plain_password']
                    ),
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat pelanggan. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $pelanggan = $this->pelangganListBaseQuery()->where('p.id', $id)->first();

        if (!$pelanggan) {
            return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return view('admin.TagihanDanPembayaran.ModulePelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        DB::beginTransaction();

        try {
            $pelanggan = $this->pelangganListBaseQuery()->where('p.id', $id)->first();
            if (!$pelanggan) {
                DB::rollBack();
                return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
            }

            DB::table('pelanggan')->where('id', $id)->update([
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('ModulePelanggan.index')
                ->with('success', 'Pelanggan berhasil diubah.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengubah pelanggan. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $pelanggan = $this->pelangganListBaseQuery()->where('p.id', $id)->first();
            if (!$pelanggan) {
                DB::rollBack();
                return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
            }

            $hasAssignment = DB::table('tagihan_user as tu')
                ->join('users as u', 'u.id', '=', 'tu.user_id')
                ->where('u.roleId', 3)
                ->where('u.idPersonal', $id)
                ->exists();

            if ($hasAssignment) {
                DB::rollBack();

                return redirect()->route('ModulePelanggan.index')
                    ->with('error', 'Pelanggan tidak dapat dihapus karena masih memiliki assignment tagihan.');
            }

            DB::table('users')
                ->where('roleId', 3)
                ->where('idPersonal', $id)
                ->delete();

            $deleted = DB::table('pelanggan')->where('id', $id)->delete();

            if (!$deleted) {
                DB::rollBack();
                return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
            }

            DB::commit();

            return redirect()->route('ModulePelanggan.index')
                ->with('success', 'Pelanggan dan akun login pelanggan berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('ModulePelanggan.index')->with('error', 'Gagal menghapus pelanggan.');
        }
    }

    private function createLoginUserForPelanggan(int $pelangganId, string $nama): array
    {
        $baseUsername = 'plg_' . $pelangganId . '_' . Str::slug($nama, '_');
        $username = Str::limit($baseUsername, 35, '');
        $counter = 1;

        while (DB::table('users')->where('username', $username)->exists()) {
            $username = Str::limit($baseUsername, 30, '') . '_' . $counter;
            $counter++;
        }

        $email = 'pelanggan' . $pelangganId . '@pelanggan.sipayda.local';
        $plainPassword = strtoupper(Str::random(2)) . random_int(1000, 9999) . strtolower(Str::random(2));

        DB::table('users')->insert([
            'roleId' => 3,
            'idJenisUser' => 2,
            'idPersonal' => $pelangganId,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($plainPassword),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'username' => $username,
            'email' => $email,
            'plain_password' => $plainPassword,
        ];
    }

    private function buildWhatsAppLink(string $phone, string $nama, string $username, string $password): string
    {
        $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
        if (Str::startsWith($normalizedPhone, '0')) {
            $normalizedPhone = '62' . substr($normalizedPhone, 1);
        }

        $message = "Halo {$nama}, akun SIPAYDA Anda sudah dibuat.\n"
            . "Username: {$username}\n"
            . "Password: {$password}\n"
            . 'Login di: ' . route('login') . "\n"
            . 'Silakan ganti password setelah login.';

        if (empty($normalizedPhone)) {
            return '#';
        }

        return 'https://wa.me/' . $normalizedPhone . '?text=' . rawurlencode($message);
    }
}
