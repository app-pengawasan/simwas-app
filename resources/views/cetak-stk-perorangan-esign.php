<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SPD</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .line-title {
            border: 0;
            border-style: inset;
            border-top: 1px solid #000;
        }

        .table-bordered {
            border: 3px;
            border-color: black;
        }

        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>td,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>td,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>td {
            border: none;
        }

        #halaman {
            font-family: Arial, Helvetica, sans-serif;
        }

        #content {
            border-color: black;
            line-height: 37px;
        }

        @page {
            margin: 1in;
        }
    </style>
</head>

<body id="halaman">
    <br><br>
    <table class="table table-borderless" style="line-height: 3px;">
        <tr>
            <td width="650px">Kementrian Negara/Lembaga:</td>
            <td style="padding-left: 50px ;" width="150px">Lembar ke</td>
            <td width="20px">:</td>
            <td colspan="2">1</td>
        </tr>
        <tr>
            <td style="padding-left: 45px ;">Badan Pusat Statistik</td>
            <td style="padding-left: 50px;">Kode No</td>
            <td>:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">Jl. Letjen Suprapto No. 48</td>
            <td style="padding-left: 50px;">Nomor</td>
            <td>:</td>
            <td colspan="1"><?= $spd['no_spd']; ?></td>
        </tr>
        <tr>
            <td style="padding-left: 85px;">Sragen</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>


    <table>
        <table style="width: 100%;">
            <tr>
                <td align="center">
                    <span style="line-height: 1.6; font-weight: bold;">
                        SURAT PERJALANAN DINAS (SPD)
                    </span>
                </td>
            </tr>
        </table>

        <br>

        <table id="content" border="1px" style="width: 100%; border-collapse: collapse;">
            <tr>
            <tr>
                <td width="30px" align="center">1</td>
                <td style="padding-left: 5px;">Pejabat Pembuat Komitmen</td>
                <td colspan="2" style="padding-left: 5px;"><?= $spd['ppk']; ?></td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td style="padding-left: 5px;">Nama/NIP Pegawai yang melaksanakan perjalanan dinas</td>
                <td colspan="2" style="padding-left: 5px;"><?= $spd['pegawai']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2" style="padding-left: 5px;">NIP : <?= $spd['nip']; ?></td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td style="padding-left: 5px;">a. Pangkat dan Golongan</td>
                <td colspan="2" style="padding-left: 5px;">a. <?= $spd['pangkat_pegawai']; ?> / (<?= $spd['golongan_pegawai']; ?>)</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">b. Jabatan / Instansi</td>
                <td colspan="2" style="padding-left: 5px;">b. <?= $spd['jabatan']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">c. Tingkat Biaya Perjalanan Dinas</td>
                <td colspan="2" style="padding-left: 5px;">c. <?= $spd['tingkat']; ?></td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td style="padding-left: 5px;">Maksud Perjalanan Dinas</td>
                <td colspan="2" style="padding-left: 5px;"><?= $spd['keperluan']; ?></td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td style="padding-left: 5px;">Alat angkutan yang dipergunakan</td>
                <td colspan="2" style="padding-left: 5px;"><?= $spd['jenis_transport']; ?></td>
            </tr>
            <tr>
                <td align="center">6</td>
                <td style="padding-left: 5px;">a. Tempat berangkat</td>
                <td colspan="2" style="padding-left: 5px;">a. <?= $spd['asal']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">b. Tempat Tujuan</td>
                <td colspan="2" style="padding-left: 5px;">b. <?= $spd['tujuan']; ?></td>
            </tr>
            <tr>
                <td align="center">7</td>
                <td style="padding-left: 5px;">a. Lamanya Perjalanan Dinas</td>
                <td colspan="2" style="padding-left: 5px;">a. <?= $spd['durasi']; ?> Hari</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">b. Tanggal berangkat</td>
                <td colspan="2" style="padding-left: 5px;">b. <?= tgl_indo($spd['tgl_berangkat']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">c. Tanggal harus kembali / tiba di tempat baru</td>
                <td colspan="2" style="padding-left: 5px;">c. <?= tgl_indo($spd['tgl_kembali']) ?></td>
            </tr>
            <tr>
                <td align="center">8</td>
                <td style="padding-left: 5px;">Pengikut</td>
                <td style="padding-left: 5px;">Umur</td>
                <td style="padding-left: 5px;">Hubungan keluarga/keterangan</td>
            </tr>
            <tr height="40px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td align="center">9</td>
                <td style="padding-left: 5px;">Pembebanan Anggaran Instansi</td>
                <td colspan="2" style="padding-left: 5px;"></td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">a. Instansi</td>
                <td colspan="2" style="padding-left: 5px;">a. BPS Kabupaten Sragen</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 5px;">b. Akun</td>
                <td colspan="2" style="padding-left: 5px;">b. <?= $spd['anggaran_akun']; ?></td>
            </tr>
            <tr>
                <td align="center">10</td>
                <td style="padding-left: 5px;">Keterangan lain - lain</td>
                <td colspan="2" style="padding-left: 5px;">No. Surat Tugas : <?= $spd['no_spt']; ?></td>
            </tr>
        </table>
        <br><br>

        <table class="table table-borderless" style="line-height: 10px;">
            <tr>
                <td width="130px">Dikeluarkan di</td>
                <td width="20px">:</td>
                <td colspan="2">Sragen</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td colspan="2"><?= tgl_indo($spd['tgl_spd']) ?></td>
            </tr>
        </table>
        <br> <br>


        <table>
            <tr>
                <td width="800px"></td>
                <td class="text-center">BADAN PUSAT STATISTIK</td>
            </tr>
            <tr>
                <td width="800px"></td>
                <td class="text-center">KABUPATEN SRAGEN</td>
            </tr>
            <tr>
                <td width="800px"></td>
                <td class="text-center">Pejabat Pembuat Komitmen</td>
            </tr>
        </table>
        <br> <br>
        <br> <br>


        <table>

            <tr>
                <td width="800px"></td>
                <td class="text-center"><u><?= $spd['ppk']; ?></u></td>
            </tr>
            <tr>
                <td width="800px"></td>
                <td class="text-center">NIP. 19670802 199401 2 001</td>
            </tr>



        </table>
        <script type="text/javascript">
            window.print();
        </script>

</body>

</html>
<?php
function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
} ?>