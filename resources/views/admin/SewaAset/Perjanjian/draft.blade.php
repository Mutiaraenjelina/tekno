@php
    \Carbon\Carbon::setLocale('id');
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Draft Dokument Surat Perjanjian Nomor: {{ $draftPerjanjian->nomorSuratPerjanjian }}</title>
    <style>
        body {
            font-family: 'Times New Roman';
            margin: 0;
            padding: 0;
        }

        .header {
            left: 00;
            right: 00;
            height: 80px;
            text-align: center;
        }

        .page-content {
            padding-top: 20px;
            font-family: 'Times New Roman';
            font-size: 12px;
        }

        /* Hide header after first page */
        @media print {
            .header {
                display: block;
                position: running(header);
            }

            .no-header {
                display: none;
            }

            @page {
                size: A4;
                margin: 25mm 20mm 25mm 20mm;

                @top-center {
                    content: element(header);
                }
            }

            .page-content::before {
                content: "";
                display: block;
                height: 0;
            }

            /* Hide header on 2nd page and beyond using JavaScript trick if needed */
        }

        .logo {
            float: left;
            width: 80px;
            height: auto;
        }

        .header-text {
            margin-left: 90px;
            text-align: left;
            text-align: center;
        }

        .clear {
            clear: both;
        }

        /* hr {
            content: "";
            display: block;
            border: 3px solid black;
        }*/

        small {
            font-size: 9px;
        }

        table {
            border-collapse: collapse;
            /*margin: 0;*/
        }

        ol.custom-list {
            list-style: none;
            counter-reset: nomor;
            padding-left: 0;
            text-align: justify;
        }

        ol.custom-list li {
            counter-increment: nomor;
            margin-bottom: 4px;
            position: relative;
            padding-left: 25px;
        }

        ol.custom-list li::before {
            content: "(" counter(nomor) ").";
            position: absolute;
            left: 0;
            /*font-weight: bold;*/
        }
    </style>
</head>

<body>
    <div class="header" id="header">
        <img src="{{ public_path('admin_resources/assets/images/user-general/logo_kab_taput.jpg') }}" class="logo"
            alt="Logo" height="80px" width="80px">
        <div class="header-text">
            <table style="text-align:center; width:100%;">
                <tr style="height: 0px; padding: 0px;">
                    <td><strong style="font-size:16px;">PEMERINTAH KABUPATEN TAPANULI UTARA</strong></td>
                </tr>
                <tr style="height: 0px; padding: 0px;">
                    <td><strong style="font-size:20px;">SEKRETARIAT DAERAH</strong></td>
                </tr>
                <tr>
                    <td style="height: 0px; padding: 0px;"><small>Jalan Let. Jend. Suprapto No.1 Telp. (0633) 21371
                            Tarutung</small></td>
                </tr>
                <tr style="height: 0px; padding: 0px;">
                    <td style="height: 0px; padding: 0px;"><small>Web site:
                            http://www.taputkab.go.id;E-mail:Sekda@taputkab.go.id</small></td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
        <hr style="border: none; height: 2px; border-top: 1px solid black; border-bottom: 3px solid black;">
    </div>

    <!-- Main content -->
    <div class="page-content">
        <div style="text-align:center;">
            <strong style="font-size:15px; text-align:center; text-decoration: underline; margin-bottom:0px;">SURAT
                PERJANJIAN</strong>
            <p style="font-size:12px; text-align:center; margin-top: 0px;">NOMOR:
                {{ $draftPerjanjian->nomorSuratPerjanjian }}
            </p>
            <p>TENTANG</p>
            <p style="font-weight: bold;">SEWA MENYEWA TANAH MILIK PEMERINTAH KABUPATEN TAPANULI UTARA</p>
        </div>
        <div style="margin-bottom:10px;">
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
                    <td style="text-align: left; vertical-align: top; width:250px;">I.
                        {{ $draftPerjanjian->namaPegawai }}
                    </td>
                    <td style="text-align: left; vertical-align: top;">:</td>
                    <td style="text-align: justify; vertical-align: top;">
                        {{ $draftPerjanjian->namaJabatanBidang }} Kabupaten Tapanuli Utara, selaku Pengelolaan Barang
                        Milik Daerah Kabupaten
                        Tapanuli Utara bertindak untuk dan atas nama Pemerintah Kabupaten Tapanuli Utara, selanjutnya
                        dalam Perjanjian disebut sebagai <strong>PIHAK KESATU</strong>;
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: top; width:250px;">II.
                        {{ $draftPerjanjian->namaWajibRetribusi }}
                    </td>
                    <td style="text-align: left; vertical-align: top;">:</td>
                    <td style="text-align: justify; vertical-align: top;">
                        Pekerjaan : {{ $draftPerjanjian->namaPekerjaan }}<br>
                        Alamat : {{ $draftPerjanjian->alamatWajibRetribusi }}<br>
                        selanjutnya dalam Perjanjian disebut sebagai <strong>PIHAK KEDUA</strong>.

                    </td>
                </tr>
            </table>
            <p style="text-indent: 30px; text-align: justify; margin-top:10px;">
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
        <div style="margin-top:0px;">
            <div style="white-space: pre; text-align: center; margin-bottom:0px;">
                BAB I
                POKOK PERJANJIAN
                Bagian Kesatu
                Objek Sewa Menyewa
                Pasal 1
            </div>
            <div style="text-align: justify; margin-top:-20px;">
                <ol class="custom-list">
                    <li>
                        PIHAK KESATU menyewakan tanah milik Pemerintah Kabupaten Tapanuli Utara kepada PIHAK KEDUA
                        dengan ukuran seluas {{ $draftPerjanjian->luasTanah }} m²
                        ({{ Riskihajar\Terbilang\Facades\Terbilang::make($draftPerjanjian->luasTanah) }} meter persegi)
                        yang
                        terletak di Lokasi {{ $draftPerjanjian->lokasiObjekRetribusi }}
                        {{ $draftPerjanjian->alamatObjekRetribusi }}.
                    </li>
                    <li>
                        Sewa menyewa tanah milik Pemerintah Kabupaten Tapanuli Utara untuk dimanfaatkan sebagai Tempat
                        Usaha dengan batas-batas sebagai berikut:
                        <table style="margin-left: 15px;">
                            <tr>
                                <td>a. </td>
                                <td style="padding-left: 10px;">Sebelah Utara</td>
                                <td>:</td>
                                <td>{{ $draftPerjanjian->batasUtara }}</td>
                            </tr>
                            <tr>
                                <td>b. </td>
                                <td style="padding-left: 10px;">Sebelah Selatan</td>
                                <td>:</td>
                                <td>{{ $draftPerjanjian->batasSelatan }}</td>
                            </tr>
                            <tr>
                                <td>c. </td>
                                <td style="padding-left: 10px;">Sebelah Timur</td>
                                <td>:</td>
                                <td>{{ $draftPerjanjian->batasTimur }}</td>
                            </tr>
                            <tr>
                                <td>d. </td>
                                <td style="padding-left: 10px;">Sebelah Barat</td>
                                <td>:</td>
                                <td>{{ $draftPerjanjian->batasBarat }}</td>
                            </tr>
                        </table>
                    </li>
                </ol>
                sebagaimana diuraikan pada peta situasi tanah dalam Lampiran Surat Perjanjian ini, dan merupakan bagian
                yang
                tidak terpisahkan dari Perjanjian ini.
            </div>
        </div>

        <div style=" margin-top:-5px;">
            <div style="white-space: pre; text-align: center;">
                Bagian Kedua
                Jangka Waktu dan Berakhirnya Perjanjian Sewa Menyewa
                Pasal 2
            </div>
            <ol class="custom-list" style=" margin-top:-7px;">
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

        <div style="text-align: justify;margin-top:-5px;">
            <div style="white-space: pre; text-align: center;">
                BAB II
                HAK DAN KEWAJIBAN PARA PIHAK
                Bagian Kesatu
                Hak dan Kewajiban Pihak KESATU
                Pasal 3
            </div>
            Dalam Perjanjian sewa menyewa ini, PIHAK KESATU mempunyai hak dan kewajiban untuk:
            <ol type="a" style=" margin-top:0px; padding-left: 20px;">
                <li style="padding-bottom: 4px; padding-left: 10px;">
                    Menerima pembayaran biaya sewa dari PIHAK KEDUA sebagaimana yang telah ditetapkan oleh Pemerintah
                    Kabupaten Tapanuli Utara.
                </li>
                <li style="padding-bottom: 4px; padding-left: 10px;">
                    Menunjuk pejabat atau petugas untuk mengawasi pelaksanaan pemanfaatan objek sewa oleh PIHAK
                    KESATU agar tetap sesuai dengan ketentuan yang tercantum dalam perjanjian sewa menyewa ini.
                </li>
                <li style="padding-bottom: 4px; padding-left: 10px;">
                    Memberikan Surat Peringatan kepada PIHAK KEDUA dalam hal PIHAK KEDUA melanggar ketentuan atau
                    persyaratan sebagaimana dimaksud dalam Surat Perjanjian Sewa Menyewa dalam pelaksanaan Surat
                    Perjanjian Sewa Menyewa.
                </li>
            </ol>
        </div>

        <div style=" margin-bottom:0px;">
            <div style="white-space: pre; text-align: center;">
                Bagian Kedua
                Hak dan Kewajiban Pihak KEDUA
                Pasal 4
            </div>
            <ol class="custom-list" style=" margin-top:-5px;">
                <li>
                    PIHAK KEDUA wajib membayar biaya sewa tanah kepada PIHAK KESATU sesuai dengan besaran yang
                    ditetapkan oleh Pemerintah Kabupaten Tapanuli Utara yang didasarkan pada nilai wajar hasil penilaian
                    oleh Tim Penilai.
                </li>
                <li>
                    Apabila belum dilakukan penilaian oleh Tim Penilai untuk menetapkan nilai wajar, maka PIHAK
                    KEDUA wajib menyetor biaya Sewa Tanah sementara tahun 2025 sesuai dengan besaran yang tertuang pada
                    SKRD Tahun 2023 ke Kas Daerah Pemerintah Kabupaten Tapanuli Utara melalui Rekening Bank Sumut dan
                    fotocopy bukti pembayaran tersebut diserahkan kepada Pihak KESATU.
                </li>
                <li>
                    Pelunasan atas biaya Sewa Tanah tahun 2025 dilakukan setelah ditetapkannya besaran sewa oleh
                    Pemerintah Kabupaten Tapanuli Utara yang didasarkan pada nilai wajar hasil penilaian oleh Tim
                    Penilai Pemerintah, selambat-lambatnya seminggu setelah besaran sewa ditetapkan.
                </li>
                <li>
                    Pembayaran sewa tanah tahun berikutnya selama jangka waktu sewa-menyewa tanah milik Pemerintah
                    Kabupaten Tapanuli Utara harus dibayarkan berdasarkan ketetapan besaran sewa yang diterbitkan oleh
                    Pemerintah Kabupaten Tapanuli Utara.
                </li>
                <li>
                    PIHAK KEDUA wajib membayar Pajak Bumi dan Bangunan (PBB) setiap tahunnya atas tanah dan bangunan
                    yang ada di atasnya, selama tenggang waktu sewa-menyewa berlangsung.
                </li>
                <li>
                    Apabila PIHAK KEDUA dalam tenggang waktu 12 (dua belas) bulan sejak Perjanjian ini ditanda
                    tangani tidak memanfaatkan tanah yang dipersewakan, maka PIHAK KESATU dapat membatalkan Perjanjian
                    ini.
                </li>
                <li>
                    PIHAK KEDUA harus mendirikan bangunan permanen di atas tanah yang dipersewakan dengan jangka
                    waktu paling lama 2 (dua) tahun sejak Perjanjian ini ditandatangani.
                </li>
                <li>
                    PIHAK KEDUA dalam melaksanakan pembangunan harus terlebih dahulu memiliki Izin Mendirikan
                    Bangunan (IMB) sesuai Peraturan Daerah Kabupaten Tapanuli Utara dan wajib mematuhi ketentuan
                    penataan bangunan yang ditetapkan oleh Instansi Teknis terkait.
                </li>
            </ol>
        </div>

        <div style=" margin-bottom:0px;">
            <div style="white-space: pre; text-align: center;">
                BAB III
                PEMBATASAN HAK SEWA
                Pasal 5
            </div>
            <ol class="custom-list" style=" margin-top:-7px;">
                <li>
                    PIHAK KEDUA tidak diperkenankan mendirikan bangunan permanen maupun non permanen melebihi ukuran
                    luas tanah yang diberikan Hak Sewa oleh PIHAK KESATU.
                </li>
                <li>
                    PIHAK KEDUA tidak dapat memindahtangankan tanah yang dipersewakan kepada pihak lain seperti
                    menjual, menggadaikan, mempersewakan atau merubah status hukum dan sebagainya tanpa persetujuan
                    PIHAK KESATU.
                </li>
                <li>
                    PIHAK KEDUA dilarang mengubah fungsi peruntukan objek sewa sehingga bertentangan dengan Rencana
                    Tata Ruang Wilayah (RTRW), Rencana Tata Ruang Kota (RTRK), dan/atau Rencana Detail Tata Ruang Kota
                    (RDTRK), baik sebagian maupun seluruhnya tanpa sepengetahuan dan seijin tertulis dari PIHAK KESATU.
                </li>
            </ol>
        </div>

        <div style=" margin-bottom:0px;">
            <div style="white-space: pre; text-align: center;">
                BAB IV
                PEMBATALAN SEWA MENYEWA
                Pasal 6
            </div>
            <div style="text-align: justify; margin-top:-5px;">
                <ol class="custom-list" style=" margin-top:0px;">
                    <li>
                        Perjanjian Sewa Menyewa ini dapat dibatalkan apabila:
                        <table style="margin-left: 15px;">
                            <tr>
                                <td style="text-align: left; vertical-align: top;">a. </td>
                                <td style="text-align: justify; vertical-align: top; padding-left: 10px;">PIHAK KEDUA
                                    melanggar
                                    ketentuan atau
                                    persyaratan sebagaimana dimaksud dalamPerjanjian
                                    ini, maka PIHAK KESATU dapat mnembatalkan perjanjian secara sepihak.</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; vertical-align: top;">b. </td>
                                <td style="text-align: justify; vertical-align: top; padding-left: 10px;">PIHAK KESATU
                                    memerlukan tanah untuk
                                    dipergunakan bagi kegiatan pembangunan/atau
                                    kepentingan umum.</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; vertical-align: top;">c.</td>
                                <td style="text-align: justify; vertical-align: top; padding-left: 10px;">PIHAK KEDUA
                                    atas
                                    kehendaknya sendiri
                                    menghentikan hak sewa tanah sebagaimanadimaksud
                                    dalam Perjanjian Sewa Menyewa.</td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        Dalam hal terjadi pembatalan Perjanjian sebagaimana dimaksud pada ayat (1) huruf a, PIHAK KESATU
                        harus terlebih dahulu memberikan peringatan tertulis sebanyak 3 (tiga) kali dalam jangka waktu
                        15
                        (lima belas) hari kalender sejak ditandatangani surat peringatan dimaksud.
                    </li>
                    <li>
                        Dalam hal terjadi pembatalan Perjanjian sebagaimana dimaksud pada ayat (1) huruf b, PIHAKKESATU
                        akan memberitahukan kepada PIHAK KEDUA dalam jangka waktu 6 (enam) bulan sebelum pelaksanaan
                        pembangunan dimulai.
                    </li>
                    <li>
                        Dalam hal terjadi pembatalan Perjanjian sebagaimana dimaksud pada ayat (1) huruf c, maka PIHAK
                        KEDUA harus memberitahukan kehendaknya tersebut secara tertulis kepada PIHAK KESATU.
                    </li>
                </ol>
            </div>
        </div>

        <div style=" margin-top:-10px;">
            <div style="white-space: pre; text-align: center;">
                Pasal 7
            </div>
            <ol class="custom-list" style=" margin-top:-5px;">
                <li>
                    Dalam hal terjadinya pembatalan perjanjian sebagaimana dimaksud dalam Pasal 6, maka PIHAK KEDUA
                    wajib mengosongkan dan menyerahkan seluruh objek sewa menyewa kepadaPIHAK KESATU dalam jangka waktu
                    15 (lima belas) hari terhitung mulai tanggal Surat Pemberitahuan Pembatalan diterima oleh masing-
                    masing pihak.
                </li>
                <li>
                    Apabila di atas tanah yang disewa tersebut terdapat bangunan yang menjadi milik PIHAK KEDUA,
                    maka PIHAK KEDUA harus segera melakukan pembongkaran bangunan dengan biaya pembongkaran ditanggung
                    oleh PIHAK KEDUA, sehingga pada saat diserahkan kepada PIHAK KESATU kondisi objek sewa kembali pada
                    keadaan semula (kosong).
                </li>
                <li>
                    Bilamana PIHAK KEDUA sampai waktu yang telah ditentukan tidak melaksanakan ketentuan sebagaimana
                    dimaksud pada ayat (2), PIHAK KESATU akan memberikan Surat Peringatan Pembongkaran 3 (tiga) kali
                    berturut- turut dalam tenggang waktu 15 (lima belas) hari.
                </li>
                <li>
                    Bilamana sampai batas waktu yang telah ditentukan dalam surat peringatan pembongkaran yang
                    ketiga (terakhir) PIHAK KEDUA tetap tidak melaksanakan ketentuan sebagaimana dimaksud pada ayat (3),
                    maka pembongkaran akan dilakukan oleh PIHAK KESATU dengan ketentuan biaya pembongkaran kepada PIHAK
                    KEDUA sebagaimana dimaksud pada ayat (2).
                </li>
                <li>
                    Semua kerugian akibat terjadinya pembatalan merupakan tanggung jawab sepenuhnya masing-masing
                    pihak, dan tidak dapat mengajukan tuntutan/klaim apapun kepada masing-masing pihak secara mutatis
                    mutandis.
                </li>
            </ol>
        </div>

        <div style=" margin-bottom:0px;">
            <div style="white-space: pre; text-align: center;">
                BAB V
                KETENTUAN SANKSI
                Pasal 8
            </div>
            <ol class="custom-list" style=" margin-top:-5px;">
                <li>
                    Dalam rangka perjanjian sewa menyewa ini, PIHAK KESATU dan PIHAK KEDUA sepakat untuk
                    mengesampingkan ketentuan Pasal 1266 dan Pasal 1267 Kitab Undang-Undang Hukum Perdata.
                </li>
                <li>
                    Apabila PIHAK KEDUA tidak membayar biaya sewa tepat waktu sesuai ketentuan yang telah ditetapkan
                    maka PIHAK KEDUA harus membayar sanksi administrasi berupa bunga sebesar 2% (dua persen) setiap
                    bulan dari besar sewa tanah yang terutang dan ditagih dengan menggunakan Surat Tagihan Sewa Tanah
                    Milik Pemerintah Kabupaten Tapanuli Utara.
                </li>
            </ol>
        </div>

        <div style=" margin-bottom:0px;">
            <div style="white-space: pre; text-align: center;">
                BAB VI
                PENYELESAIAN PERSELISIHAN
                Pasal 9
            </div>
            <ol class="custom-list" style=" margin-top:-7px;">
                <li>
                    Apabila terjadi perselisihan pendapat antara PIHAK KESATU dengan PIHAK KEDUA mengenai penafsiran dan
                    pelaksanaan syarat-syarat dan ketentuan dalam Surat Perjanjian ini, maka kedua belah pihak sepakat
                    menyelesaikan secara musyawarah untuk mufakat.
                </li>
                <li>
                    Apabila musyawarah untuk mufakat sebagaimana dimaksud pada ayat (1) tidak tercapai penyelesaian,
                    maka PIHAK KESATU dan PIHAK KEDUA sepakat menyerahkan sepenuh upaya penyelesaiannya di kepaniteraan
                    Pengadilan Negeri Tarutung.
                </li>
            </ol>
        </div>

        <div style=" margin-bottom:0px;">
            <div style="white-space: pre; text-align: center;">
                BAB VII
                KETENTUAN LAIN-LAIN
                Pasal 10
            </div>
            <div style="margin-top:-7px;">
                Biaya yang berhubungan dengan pelaksanaan Surat Perjanjian Sewa Menyewa ini dibebankan kepada PIHAK
                KEDUA.
            </div>
        </div>

        <div style="margin-top:5px;">
            <div style="white-space: pre; text-align: center;">
                Pasal 11
            </div>
            <div style="text-align: justify; margin-top:-5px;">
                Apabila terjadi perubahan dalam ketentuan peraturan perundang-undangan di bidang pertanahan yang
                mempengaruhi perjanjian sewa menyewa ini, Para Pibak sepakat untuk mengadakan perubahan- perubahan dan
                penyesuaian atas Surat Perjanjian Sewa Menyewa ini.
            </div>
        </div>

        <div style=" margin-top:15px;">
            <div style="white-space: pre; text-align: center;">
                BAB VIII
                PENUTUP
                Pasal 12
            </div>
            <div style="text-align: justify; margin-top:-5px;">
                Demikian Perjanjian Sewa-Menyewa tanah ini ditandatangani oleh kedua belah pihak, pada hari dan tanggal
                tersebut di atas dan diperbuat dengan sesungguhnya dalam rangkap 2 (dua) masing-masing dibubuhi Materai
                cukup dan mempunyai kekuatan hukum yang sama, I (satu) rangkap untuk PIHAK KESATU dan 1 (satu) rangkap
                untuk
                PIHAK KEDUA.
            </div>
        </div>

        <div style="margin-top:50px;">
            <div>
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width:40%;">PIHAK KEDUA,</th>
                            <th style="width:20%;"></th>
                            <th style="width:40%;">PIHAK KESATU,</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td
                                style="text-align: center; font-weight: bold; padding-top: 60px; text-transform: uppercase;">
                                {{ $draftPerjanjian->namaPegawai }}
                            </td>
                            <td></td>
                            <td
                                style="text-align: center; font-weight: bold; padding-top: 60px; text-transform: uppercase;">
                                {{ $draftPerjanjian->namaWajibRetribusi }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="text-align: justify;">

            </div>
        </div>

        <div style=" margin-top:60px;">
            <div style="text-align: left;">
                Saksi-saksi:
            </div>
            <div style="text-align: justify;">
                <table style="width: 100%;">
                    @if (isset($saksiPerjanjian) && count($saksiPerjanjian) > 0)
                        @foreach ($saksiPerjanjian as $sP)
                            <tr>
                                <td style="width: 3%; height: 30px;">{{ $loop->iteration }}.</td>
                                <td style="width: 37%;">{{ $sP->namaSaksi }}</td>
                                <td style="width: 60%;">(________________)</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>

</body>

</html>