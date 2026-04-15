<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EfranCoreController extends Controller
{
    public function dashboard()
    {
        $totalTagihan = DB::table('tagihansewa')->where('isDeleted', 0)->count();
        $totalBayar = DB::table('tagihansewa')->where('isDeleted', 0)->where('idStatus', 3)->count();
        $totalBelumBayar = DB::table('tagihansewa')->where('isDeleted', 0)->where(function ($query) {
            $query->whereNull('idStatus')->orWhere('idStatus', '!=', 3);
        })->count();

        return response()->json([
            'status' => 200,
            'data' => [
                'total_tagihan' => $totalTagihan,
                'total_bayar' => $totalBayar,
                'total_belum_bayar' => $totalBelumBayar,
            ],
        ]);
    }

    public function tagihanDetail($idTagihan)
    {
        $tagihan = DB::table('tagihansewa as t')
            ->join('perjanjiansewa as ps', 'ps.idPerjanjianSewa', '=', 't.idPerjanjianSewa')
            ->join('permohonansewa as pm', 'pm.idPermohonanSewa', '=', 'ps.idPermohonan')
            ->join('wajibretribusi as w', 'w.idWajibRetribusi', '=', 'pm.idWajibRetribusi')
            ->leftJoin('pembayaransewa as pb', 'pb.idPerjanjianSewa', '=', 'ps.idPerjanjianSewa')
            ->select(
                't.idTagihanSewa',
                't.idPerjanjianSewa',
                't.nomorTagihan',
                't.trxId',
                't.noVirtualAccount',
                't.tanggalJatuhTempo',
                't.tanggalNotifikasi',
                't.expiredDatePembayaran',
                't.jumlahTagihan',
                't.jumlahDenda',
                't.idStatus',
                'ps.nomorSuratPerjanjian',
                'w.idWajibRetribusi',
                'w.namaWajibRetribusi',
                'w.nomorPonsel',
                'w.email',
                DB::raw('COALESCE(pb.idPembayaranSewa, 0) as payment_id'),
                DB::raw('COALESCE(pb.isKonfirmasi, 0) as payment_status')
            )
            ->where('t.idTagihanSewa', $idTagihan)
            ->first();

        if (! $tagihan) {
            return response()->json([
                'status' => 404,
                'message' => 'Tagihan tidak ditemukan.',
            ], 404);
        }

        $assignments = [];

        if (Schema::hasTable('tagihan_user')) {
            $assignments = DB::table('tagihan_user as tu')
                ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
                ->select(
                    'tu.id',
                    'tu.tagihan_id',
                    'tu.user_id',
                    'tu.status',
                    'tu.payment_id',
                    'u.username',
                    'u.email'
                )
                ->where('tu.tagihan_id', $idTagihan)
                ->get();
        }

        return response()->json([
            'status' => 200,
            'data' => [
                'tagihan' => $tagihan,
                'assignments' => $assignments,
            ],
        ]);
    }
    
        public function assignmentsIndex(Request $request)
        {
            if (! Schema::hasTable('tagihan_user')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tabel tagihan_user belum tersedia.',
                ], 500);
            }

            $validated = $request->validate([
                'tagihan_id' => ['nullable', 'integer'],
                'user_id' => ['nullable', 'integer'],
                'status' => ['nullable', 'in:belum,sudah'],
            ]);

            $query = $this->assignmentBaseQuery();

            if (! empty($validated['tagihan_id'])) {
                $query->where('tu.tagihan_id', $validated['tagihan_id']);
            }

            if (! empty($validated['user_id'])) {
                $query->where('tu.user_id', $validated['user_id']);
            }

            if (! empty($validated['status'])) {
                $query->where('tu.status', $validated['status']);
            }

            return response()->json([
                'status' => 200,
                'data' => $query->orderByDesc('tu.id')->get(),
            ]);
        }

        public function assignmentShow($id)
        {
            if (! Schema::hasTable('tagihan_user')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tabel tagihan_user belum tersedia.',
                ], 500);
            }

            $assignment = $this->assignmentBaseQuery()->where('tu.id', $id)->first();

            if (! $assignment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Assignment tidak ditemukan.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'data' => $assignment,
            ]);
        }

        public function assignmentStore(Request $request)
        {
            if (! Schema::hasTable('tagihan_user')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tabel tagihan_user belum tersedia.',
                ], 500);
            }

            $validated = $request->validate([
                'tagihan_id' => ['required', 'integer'],
                'user_id' => ['required', 'integer'],
                'status' => ['nullable', 'in:belum,sudah'],
                'payment_id' => ['nullable', 'integer'],
            ]);

            $relationError = $this->validateTagihanUserRelation($validated['tagihan_id'], $validated['user_id']);
            if ($relationError) {
                return response()->json([
                    'status' => 422,
                    'message' => $relationError,
                ], 422);
            }

            if (! empty($validated['payment_id'])) {
                $paymentExists = DB::table('pembayaransewa')
                    ->where('idPembayaranSewa', $validated['payment_id'])
                    ->exists();

                if (! $paymentExists) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Payment ID tidak ditemukan.',
                    ], 422);
                }
            }

            $duplicate = DB::table('tagihan_user')
                ->where('tagihan_id', $validated['tagihan_id'])
                ->where('user_id', $validated['user_id'])
                ->exists();

            if ($duplicate) {
                return response()->json([
                    'status' => 409,
                    'message' => 'Assignment sudah ada untuk kombinasi tagihan dan user tersebut.',
                ], 409);
            }

            $assignmentId = DB::table('tagihan_user')->insertGetId([
                'tagihan_id' => $validated['tagihan_id'],
                'user_id' => $validated['user_id'],
                'status' => $validated['status'] ?? 'belum',
                'payment_id' => $validated['payment_id'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Assignment berhasil dibuat.',
                'data' => ['id' => $assignmentId],
            ]);
        }

        public function assignmentUpdate(Request $request, $id)
        {
            if (! Schema::hasTable('tagihan_user')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tabel tagihan_user belum tersedia.',
                ], 500);
            }

            $assignment = DB::table('tagihan_user')->where('id', $id)->first();

            if (! $assignment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Assignment tidak ditemukan.',
                ], 404);
            }

            $validated = $request->validate([
                'tagihan_id' => ['nullable', 'integer'],
                'user_id' => ['nullable', 'integer'],
                'status' => ['nullable', 'in:belum,sudah'],
                'payment_id' => ['nullable', 'integer'],
            ]);

            $nextTagihanId = $validated['tagihan_id'] ?? $assignment->tagihan_id;
            $nextUserId = $validated['user_id'] ?? $assignment->user_id;

            $relationError = $this->validateTagihanUserRelation((int) $nextTagihanId, (int) $nextUserId);
            if ($relationError) {
                return response()->json([
                    'status' => 422,
                    'message' => $relationError,
                ], 422);
            }

            if (array_key_exists('payment_id', $validated) && ! empty($validated['payment_id'])) {
                $paymentExists = DB::table('pembayaransewa')
                    ->where('idPembayaranSewa', $validated['payment_id'])
                    ->exists();

                if (! $paymentExists) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Payment ID tidak ditemukan.',
                    ], 422);
                }
            }

            $conflict = DB::table('tagihan_user')
                ->where('tagihan_id', $nextTagihanId)
                ->where('user_id', $nextUserId)
                ->where('id', '!=', $id)
                ->exists();

            if ($conflict) {
                return response()->json([
                    'status' => 409,
                    'message' => 'Kombinasi tagihan dan user sudah digunakan assignment lain.',
                ], 409);
            }

            $payload = [
                'tagihan_id' => $nextTagihanId,
                'user_id' => $nextUserId,
                'updated_at' => now(),
            ];

            if (array_key_exists('status', $validated)) {
                $payload['status'] = $validated['status'];
            }

            if (array_key_exists('payment_id', $validated)) {
                $payload['payment_id'] = $validated['payment_id'];
            }

            DB::table('tagihan_user')->where('id', $id)->update($payload);

            return response()->json([
                'status' => 200,
                'message' => 'Assignment berhasil diperbarui.',
            ]);
        }

        public function assignmentDelete($id)
        {
            if (! Schema::hasTable('tagihan_user')) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tabel tagihan_user belum tersedia.',
                ], 500);
            }

            $deleted = DB::table('tagihan_user')->where('id', $id)->delete();

            if (! $deleted) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Assignment tidak ditemukan.',
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Assignment berhasil dihapus.',
            ]);
        }

        private function assignmentBaseQuery()
        {
            return DB::table('tagihan_user as tu')
                ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
                ->leftJoin('tagihansewa as t', 't.idTagihanSewa', '=', 'tu.tagihan_id')
                ->select(
                    'tu.id',
                    'tu.tagihan_id',
                    'tu.user_id',
                    'tu.status',
                    'tu.payment_id',
                    'tu.created_at',
                    'tu.updated_at',
                    'u.username',
                    'u.email',
                    't.nomorTagihan',
                    't.jumlahTagihan',
                    't.tanggalJatuhTempo'
                );
        }

        private function validateTagihanUserRelation(int $tagihanId, int $userId): ?string
        {
            $tagihanData = DB::table('tagihansewa as t')
                ->join('perjanjiansewa as ps', 'ps.idPerjanjianSewa', '=', 't.idPerjanjianSewa')
                ->join('permohonansewa as pm', 'pm.idPermohonanSewa', '=', 'ps.idPermohonan')
                ->select('pm.idWajibRetribusi')
                ->where('t.idTagihanSewa', $tagihanId)
                ->first();

            $userData = DB::table('users')->select('idPersonal')->where('id', $userId)->first();

            if (! $tagihanData || ! $userData) {
                return 'Tagihan atau user tidak ditemukan.';
            }

            if ((int) $tagihanData->idWajibRetribusi !== (int) $userData->idPersonal) {
                return 'User tidak terkait dengan pelanggan pada tagihan tersebut.';
            }

            return null;
        }


    public function createTransaksi(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0'],
            'metode' => ['required', 'string', 'max:50'],
            'order_id' => ['required', 'string', 'max:20'],
            'status' => ['required', 'string', 'max:20'],
        ]);

        $tagihan = DB::table('tagihansewa')->where('idTagihanSewa', $validated['tagihan_id'])->first();

        if (! $tagihan) {
            return response()->json([
                'status' => 404,
                'message' => 'Tagihan tidak ditemukan.',
            ], 404);
        }

        $paymentId = DB::table('pembayaransewa')->insertGetId([
            'idPerjanjianSewa' => $tagihan->idPerjanjianSewa,
            'noInvoice' => $validated['order_id'],
            'tanggalCetak' => now()->toDateString(),
            'totalBayar' => $validated['amount'],
            'waktuAkhirBayar' => now()->addDays(1),
            'idStatus' => $validated['status'] === 'success' ? 3 : 1,
            'isKonfirmasi' => $validated['status'] === 'success' ? '1' : '0',
            'keterangan' => 'metode=' . $validated['metode'] . '; order_id=' . $validated['order_id'],
            'createdBy' => $validated['user_id'],
            'createAt' => now(),
            'updateAt' => now(),
            'isDeleted' => 0,
        ]);

        if (Schema::hasTable('tagihan_user')) {
            DB::table('tagihan_user')->updateOrInsert(
                [
                    'tagihan_id' => $validated['tagihan_id'],
                    'user_id' => $validated['user_id'],
                ],
                [
                    'status' => $validated['status'] === 'success' ? 'sudah' : 'belum',
                    'payment_id' => $paymentId,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return response()->json([
            'status' => 200,
            'message' => 'Transaksi berhasil dibuat.',
            'data' => [
                'payment_id' => $paymentId,
                'tagihan_id' => $validated['tagihan_id'],
                'user_id' => $validated['user_id'],
                'amount' => $validated['amount'],
                'metode' => $validated['metode'],
                'order_id' => $validated['order_id'],
                'status' => $validated['status'],
            ],
        ]);
    }

    public function updateStatusPembayaran(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['required', 'integer'],
            'user_id' => ['nullable', 'integer'],
            'payment_id' => ['nullable', 'integer'],
            'status' => ['required', 'string', 'max:20'],
        ]);

        $tagihan = DB::table('tagihansewa')->where('idTagihanSewa', $validated['tagihan_id'])->first();

        if (! $tagihan) {
            return response()->json([
                'status' => 404,
                'message' => 'Tagihan tidak ditemukan.',
            ], 404);
        }

        $statusId = $validated['status'] === 'success' ? 3 : 1;

        DB::table('tagihansewa')
            ->where('idTagihanSewa', $validated['tagihan_id'])
            ->update([
                'idStatus' => $statusId,
                'updateAt' => now(),
            ]);

        if (! empty($validated['payment_id'])) {
            DB::table('pembayaransewa')
                ->where('idPembayaranSewa', $validated['payment_id'])
                ->update([
                    'idStatus' => $statusId,
                    'isKonfirmasi' => $validated['status'] === 'success' ? '1' : '0',
                    'updateAt' => now(),
                ]);
        }

        if (Schema::hasTable('tagihan_user')) {
            $updatePayload = [
                'status' => $validated['status'] === 'success' ? 'sudah' : 'belum',
                'updated_at' => now(),
            ];

            if (! empty($validated['payment_id'])) {
                $updatePayload['payment_id'] = $validated['payment_id'];
            }

            $query = DB::table('tagihan_user')->where('tagihan_id', $validated['tagihan_id']);

            if (! empty($validated['user_id'])) {
                $query->where('user_id', $validated['user_id']);
            }

            $query->update($updatePayload);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Status pembayaran berhasil diperbarui.',
            'data' => [
                'tagihan_id' => $validated['tagihan_id'],
                'user_id' => $validated['user_id'] ?? null,
                'payment_id' => $validated['payment_id'] ?? null,
                'status' => $validated['status'],
            ],
        ]);
    }
}
