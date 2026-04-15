<div>
    <div style="white-space: pre; text-align: center;">
        Bagian Kedua
        Jangka Waktu dan Berakhirnya Perjanjian Sewa Menyewa
        Pasal 2
    </div>
    <ol class="custom-list">
        <li>
            Jangka waktu Perjanjian Sewa-Menyewa pemakaian tanah milik Pemerintah Kabupaten Tapanuli Utara
            ini berlaku selama {{ $draftPerjanjian->lamaSewa }}
            ({{ Riskihajar\Terbilang\Facades\Terbilang::make($draftPerjanjian->lamaSewa) }})
            {{ $draftPerjanjian->namaSatuan }} terhitung sejak tanggal
            {{ \Carbon\Carbon::parse($draftPerjanjian->tanggalAwalBerlaku)->translatedFormat('d F Y') }} sampai
            dengan tanggal
            {{ \Carbon\Carbon::parse($draftPerjanjian->tanggalAkhirBerlaku)->translatedFormat('d F Y') }}.
        </li>
        <li>
            Apabila PIHAK KEDUA ingin memperpanjang Perjanjian Sewa-Menyewa tanah dimaksud maka PIHAK KEDUA
            selambat-lambatnya 2 (dua) bulan sebelun berakhir masa Perjanjian ini harus menyampaikan permohonan
            perpanjangan kepada PIHAK KESATU.
        </li>
        <li>
            Apabila setelah jangka waktu 2 (dua) bulan setelah berakhirnya Surat Perjanjian Sewa Menyewa,
            PIHAK KEDUA tidak mengajukan Surat Permohonan perpanjangan, maka PHAK KEDUA dianggap telah
            mengundurkan diri dan Surat Perjanjian Sewa Menyewa ini tidak berlaku lagi.
        </li>
    </ol>
</div>


<p><strong>Hari:</strong>
<p>Hari: {{ \Carbon\Carbon::parse($draftPerjanjian->tanggalDisahkan)->translatedFormat('l') }}</p>
</p>
<p><strong>Description:</strong> {{ $draftPerjanjian->namaPegawai }}</p>
<p><strong>Created at:</strong> {{ $draftPerjanjian->namaStatus }}</p>