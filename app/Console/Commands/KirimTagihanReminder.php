<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KirimTagihanReminder extends Command
{
    protected $signature = 'tagihan:reminder {--days=3 : Minimal hari jatuh tempo yang sudah terlewati}';

    protected $description = 'Generate reminder pembayaran untuk tagihan yang belum dibayar dan sudah jatuh tempo.';

    public function handle(): int
    {
        $days = max(0, (int) $this->option('days'));
        $thresholdDate = now()->subDays($days)->toDateString();

        $reminders = DB::table('tagihan_user as tu')
            ->join('tagihan as t', 'tu.tagihan_id', '=', 't.id')
            ->join('users as u', 'tu.user_id', '=', 'u.id')
            ->leftJoin('pelanggan as p', 'u.idPersonal', '=', 'p.id')
            ->leftJoin('transaksi as tr', 'tu.payment_id', '=', 'tr.id')
            ->where('tu.status', 'belum')
            ->whereDate('t.jatuh_tempo', '<=', $thresholdDate)
            ->select(
                'tu.id as assignment_id',
                't.nama_tagihan',
                't.nominal',
                't.jatuh_tempo',
                'u.username',
                'u.email',
                'p.no_wa',
                'tr.order_id'
            )
            ->orderBy('t.jatuh_tempo')
            ->get();

        if ($reminders->isEmpty()) {
            $this->info('Tidak ada tagihan yang perlu diingatkan.');
            return self::SUCCESS;
        }

        $this->info('Reminder tagihan yang bisa dikirim: ' . $reminders->count());
        $this->newLine();

        foreach ($reminders as $reminder) {
            $phone = preg_replace('/[^0-9]/', '', (string) $reminder->no_wa);
            $message = trim(sprintf(
                "Halo %s, tagihan %s sebesar Rp %s jatuh tempo pada %s belum dibayar. Mohon segera melakukan pembayaran.",
                $reminder->username ?? 'Pelanggan',
                $reminder->nama_tagihan,
                number_format((float) $reminder->nominal, 0, ',', '.'),
                \Carbon\Carbon::parse($reminder->jatuh_tempo)->format('d-m-Y')
            ));

            $waLink = $phone !== ''
                ? 'https://wa.me/' . $phone . '?text=' . urlencode($message)
                : '(nomor WhatsApp belum tersedia)';

            $line = sprintf(
                "- [%s] %s | %s | %s",
                $reminder->assignment_id,
                $reminder->username ?? '-',
                $reminder->nama_tagihan,
                $waLink
            );

            $this->line($line);

            Log::info('Reminder tagihan generated', [
                'assignment_id' => $reminder->assignment_id,
                'username' => $reminder->username,
                'wa_link' => $waLink,
                'order_id' => $reminder->order_id,
            ]);
        }

        return self::SUCCESS;
    }
}
