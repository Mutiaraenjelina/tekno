<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TagihanUserController extends Controller
{
    private function isSuperAdmin(): bool
    {
        return Auth::check() && (string) Auth::user()->roleId === '1';
    }

    private function ownedPelangganScope()
    {
        $query = DB::table('pelanggan as p');

        if (Auth::check() && (string) Auth::user()->roleId === '2') {
            $query->where('p.owner_user_id', Auth::id());
        }

        return $query;
    }

    private function createGuestUserForPelanggan(int $pelangganId, string $nama): void
    {
        $baseUsername = 'guest_' . $pelangganId . '_' . Str::slug($nama, '_');
        $username = Str::limit($baseUsername, 40, '');
        $counter = 1;

        while (DB::table('users')->where('username', $username)->exists()) {
            $username = Str::limit($baseUsername, 35, '') . '_' . $counter;
            $counter++;
        }

        $email = 'guest' . $pelangganId . '@guest.tapatupa.local';

        DB::table('users')->insert([
            'roleId' => 3,
            'idJenisUser' => 2,
            'idPersonal' => $pelangganId,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make(Str::random(24)),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function ensureGuestUsersForExistingPelanggan(): void
    {
        $pelangganWithoutGuest = $this->ownedPelangganScope()
            ->leftJoin('users as u', function ($join) {
                $join->on('u.idPersonal', '=', 'p.id')
                    ->where('u.roleId', '=', 3);
            })
            ->whereNull('u.id')
            ->select('p.id', 'p.nama')
            ->get();

        foreach ($pelangganWithoutGuest as $pelanggan) {
            $this->createGuestUserForPelanggan((int) $pelanggan->id, (string) $pelanggan->nama);
        }
    }

    public function index()
    {
        $this->ensureGuestUsersForExistingPelanggan();

        if (! Schema::hasTable('tagihan_user')) {
            return redirect()->route('Dashboard.index')->with('error', 'Tabel tagihan_user belum tersedia.');
        }

        $assignments = DB::table('tagihan_user as tu')
            ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->leftJoin('tagihan as t', 't.id', '=', 'tu.tagihan_id')
            ->leftJoin('transaksi as tr', 'tr.id', '=', 'tu.payment_id')
            ->when(!$this->isSuperAdmin(), function ($query) {
                $query->where('p.owner_user_id', Auth::id())
                    ->where('t.created_by', Auth::id());
            })
            ->select(
                'tu.id',
                'tu.tagihan_id',
                'tu.user_id',
                'tu.status',
                'tu.payment_id',
                'u.username',
                'u.email',
                'p.no_wa',
                't.nama_tagihan',
                't.nominal',
                't.jatuh_tempo',
                'tr.order_id',
                'tr.status as transaksi_status'
            )
            ->orderByDesc('tu.id')
            ->get();

        $tagihanOptions = DB::table('tagihan')
            ->when(!$this->isSuperAdmin(), function ($query) {
                $query->where('created_by', Auth::id());
            })
            ->select('id', 'nama_tagihan', 'nominal', 'jatuh_tempo')
            ->orderByDesc('id')
            ->limit(300)
            ->get();

        $userOptions = DB::table('users as u')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->when(!$this->isSuperAdmin(), function ($query) {
                $query->where('p.owner_user_id', Auth::id());
            })
            ->select('u.id', 'u.username', 'u.email', 'p.nama as namaPelanggan')
            ->where('u.roleId', 3)
            ->orderBy('u.username')
            ->get();

        $pelangganBelumDitagih = DB::table('users as u')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->leftJoin('tagihan_user as tu', 'tu.user_id', '=', 'u.id')
            ->where('u.roleId', 3)
            ->when(!$this->isSuperAdmin(), function ($query) {
                $query->where('p.owner_user_id', Auth::id());
            })
            ->whereNull('tu.id')
            ->select('u.id', 'u.username', 'p.nama as namaPelanggan', 'p.no_wa')
            ->orderByDesc('u.id')
            ->limit(10)
            ->get();

        $assignmentBelumBayarCount = DB::table('tagihan_user')
            ->where('status', 'belum')
            ->count();

        $pembayaranSuksesHariIniCount = DB::table('transaksi')
            ->whereIn(DB::raw('LOWER(status)'), ['success', 'settlement', 'capture'])
            ->whereDate('updated_at', today())
            ->count();

        return view('admin.TagihanDanPembayaran.TagihanUser.index', compact(
            'assignments',
            'tagihanOptions',
            'userOptions',
            'pelangganBelumDitagih',
            'assignmentBelumBayarCount',
            'pembayaranSuksesHariIniCount'
        ));
    }

    public function store(Request $request)
    {
        $request->merge([
            'payment_id' => $request->filled('payment_id') ? $request->input('payment_id') : null,
        ]);

        $validated = $request->validate([
            'tagihan_id' => ['nullable', 'integer', 'required_without:tagihan_id_manual'],
            'tagihan_id_manual' => ['nullable', 'integer', 'required_without:tagihan_id'],
            'user_id' => ['required', 'integer'],
            'status' => ['required', 'in:belum,sudah'],
            'payment_id' => ['nullable', 'integer', 'exists:transaksi,id'],
        ], [
            'tagihan_id.required_without' => 'Pilih tagihan dari dropdown atau isi ID tagihan manual.',
            'tagihan_id_manual.required_without' => 'Isi ID tagihan manual atau pilih dari dropdown.',
            'tagihan_id.integer' => 'Tagihan dari dropdown tidak valid.',
            'tagihan_id_manual.integer' => 'ID tagihan manual harus berupa angka.',
            'user_id.required' => 'User wajib dipilih.',
            'user_id.integer' => 'User tidak valid.',
            'payment_id.integer' => 'Payment ID harus berupa angka.',
            'payment_id.exists' => 'Payment ID tidak ditemukan di data transaksi.',
        ]);

        $tagihanId = (int) ($validated['tagihan_id_manual'] ?? $validated['tagihan_id']);

        $relationError = $this->validateTagihanUserRelation($tagihanId, $validated['user_id']);
        if ($relationError) {
            return redirect()->route('TagihanUser.index')->with('error', $relationError);
        }

        $exists = DB::table('tagihan_user')
            ->where('tagihan_id', $tagihanId)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return redirect()->route('TagihanUser.index')->with('error', 'Assignment sudah ada.');
        }

        DB::table('tagihan_user')->insert([
            'tagihan_id' => $tagihanId,
            'user_id' => $validated['user_id'],
            'status' => $validated['status'],
            'payment_id' => $validated['payment_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('TagihanUser.index')->with('success', 'Assignment berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $assignment = DB::table('tagihan_user')->where('id', $id)->first();

        if (! $assignment) {
            return redirect()->route('TagihanUser.index')->with('error', 'Assignment tidak ditemukan.');
        }

        $request->merge([
            'payment_id' => $request->filled('payment_id') ? $request->input('payment_id') : null,
        ]);

        $validated = $request->validate([
            'status' => ['required', 'in:belum,sudah'],
            'payment_id' => ['nullable', 'integer', 'exists:transaksi,id'],
        ], [
            'payment_id.integer' => 'Payment ID harus berupa angka.',
            'payment_id.exists' => 'Payment ID tidak ditemukan di data transaksi.',
        ]);

        DB::table('tagihan_user')->where('id', $id)->update([
            'status' => $validated['status'],
            'payment_id' => $validated['payment_id'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('TagihanUser.index')->with('success', 'Assignment berhasil diperbarui.');
    }

    public function delete($id)
    {
        DB::table('tagihan_user')->where('id', $id)->delete();

        return redirect()->route('TagihanUser.index')->with('success', 'Assignment berhasil dihapus.');
    }

    private function validateTagihanUserRelation(int $tagihanId, int $userId): ?string
    {
        $tagihanData = DB::table('tagihan')
            ->select('id', 'created_by')
            ->where('id', $tagihanId)
            ->first();

        $userData = DB::table('users as u')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->select('u.idPersonal', 'p.owner_user_id')
            ->where('u.id', $userId)
            ->first();

        if (! $tagihanData) {
            return 'Tagihan tidak ditemukan. Periksa ID tagihan yang dipilih/diinput.';
        }

        if (! $userData) {
            return 'User tidak ditemukan. Silakan pilih user yang valid.';
        }

        if (! DB::table('pelanggan')->where('id', $userData->idPersonal)->exists()) {
            return 'User tidak terkait dengan data pelanggan.';
        }

        if (! $this->isSuperAdmin()) {
            if ((int) ($tagihanData->created_by ?? 0) !== (int) Auth::id()) {
                return 'Tagihan tidak termasuk data milik Anda.';
            }

            if ((int) ($userData->owner_user_id ?? 0) !== (int) Auth::id()) {
                return 'User tidak termasuk data pelanggan milik Anda.';
            }
        }

        return null;
    }
}
