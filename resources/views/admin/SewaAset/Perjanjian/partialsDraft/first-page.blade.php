<div style="text-align:center;">
    <strong style="font-size:15px; text-align:center;">SURAT PERJANJIAN</strong>
    <p style="font-size:12px; text-align:center;">NOMOR: {{ $draftPerjanjian->nomorSuratPerjanjian }}</p>
    <p>TENTANG</p>
    <p style="font-weight: bold;">SEWA MENYEWA TANAH MILIK PEMERINTAH KABUPATEN TAPANULI UTARA</p>
</div>
<div>
    <p style="text-indent: 30px; text-align: justify;">
        Pada hari ini, {{ \Carbon\Carbon::parse($draftPerjanjian->tanggalDisahkan)->translatedFormat('l') }}
        tanggal
        {{ Riskihajar\Terbilang\Facades\Terbilang::make(\Carbon\Carbon::parse('2025-04-17')->format('d')) }}
        bulan {{ \Carbon\Carbon::parse($draftPerjanjian->tanggalDisahkan)->translatedFormat('F') }} tahun
        {{ Riskihajar\Terbilang\Facades\Terbilang::make(\Carbon\Carbon::parse('2025-04-17')->format('Y')) }}
        bertempat di Tarutung, kami yang bertanda tangan di bawah ini:
    </p>
    <table>
        <tr>
            <td style="width:250px;">I. {{ $draftPerjanjian->namaPegawai }}</td>
            <td>:</td>
            <td style="text-align: justify;">
                {{ $draftPerjanjian->namaJabatanBidang }} Kabupaten Tapanuli Utara, selaku Pengelolaan Barang
                Milik Daerah Kabupaten
                Tapanuli Utara bertindak untuk dan atas nama Pemerintah Kabupaten Tapanuli Utara, selanjutnya
                dalam Perjanjian disebut sebagai <strong>PIHAK KESATU</strong>;
            </td>
        </tr>
        <tr>
            <td>II. {{ $draftPerjanjian->namaWajibRetribusi }}</td>
            <td>:</td>
            <td style="text-align: justify;">
                Pekerjaan : {{ $draftPerjanjian->namaPekerjaan }}<br>
                Alamat : {{ $draftPerjanjian->alamatWajibRetribusi }}<br>
                selanjutnya dalam Perjanjian disebut sebagai <strong>PIHAK KEDUA</strong>.

            </td>
        </tr>
    </table><br>
    <p style="text-indent: 30px; text-align: justify;">
        Berdasarkan Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 7 Tahun 2024 tentang Perubahan Atas
        Peraturan Menteri Dalam Negeri Nomor 19 Tahun 2016 tentang Pedoman Pengelolaan Barang Milik Daerah,
        Peraturan Daerah Kabupaten Tapanuli Utara Nomor 08 Tahun 2016 tentang Pengelolaan Barang Milik Daerah
        dan
        Peraturan Bupati Tapanuli Utara Nomor 38 Tahun 2016 tentang Pedoman Pengelolaan Barang Milik Daerah dan
        Surat Permohonan PIHAK KEDUA tanggal
        {{ \Carbon\Carbon::parse($draftPerjanjian->tanggalPermohonan)->translatedFormat('d F Y') }}, PIHAK
        KESATU
        dan PIHAK KEDUA tersebut di atas,
        sepakat membuat dan mengadakan Perjanjian tentang <strong>“Sewa Menyewa Tanah Milik Pemerintah Kabupaten
            Tapanuli Utara"</strong> terletak di Lokasi {{ $draftPerjanjian->lokasiObjekRetribusi }}
        {{ $draftPerjanjian->alamatObjekRetribusi }}, dengan ketentuan sebagai berikut:
    </p>
</div>
<div>
    <div style="white-space: pre; text-align: center;">
        BAB I
        POKOK PERJANJIAN
        Bagian Kesatu
        Objek Sewa Menyewa
        Pasal 1
    </div>
    <ol class="custom-list">
        <li>
            PIHAK KESATU menyewakan tanah milik Pemerintah Kabupaten Tapanuli Utara kepada PIHAK KEDUA
            dengan
            ukuran seluas 62,5 m² (enam puluh dua koma lima meter persegi) yang terletak di Lokasi Luar Pekan
            Jl.
            Sisingamangaraja Kecamatan Tarutung, Kabupaten Tapanuli Utara.
        </li>
        <li>
            Sewa menyewa tanah milik Pemerintah Kabupaten Tapanuli Utara untuk dimanfaatkan sebagai Tempat
            Usaha
            dengan batas-batas sebagai berikut:
            <table>
                <tr>
                    <td>a. </td>
                    <td>Sebelah Utara</td>
                    <td>:</td>
                    <td>{{ $draftPerjanjian->batasUtara }}</td>
                </tr>
                <tr>
                    <td>b. </td>
                    <td>Sebelah Selatan</td>
                    <td>:</td>
                    <td>{{ $draftPerjanjian->batasSelatan }}</td>
                </tr>
                <tr>
                    <td>c. </td>
                    <td>Sebelah Timur</td>
                    <td>:</td>
                    <td>{{ $draftPerjanjian->batasTimur }}</td>
                </tr>
                <tr>
                    <td>d. </td>
                    <td>Sebelah Barat</td>
                    <td>:</td>
                    <td>{{ $draftPerjanjian->batasBarat }}</td>
                </tr>
            </table>
        </li>
    </ol>
    sebagaimana diuraikan pada peta situasi tanah dalam Lampiran Surat Perjanjian ini, dan merupakan bagian yang
    tidak terpisahkan dari Perjanjian ini.
</div>