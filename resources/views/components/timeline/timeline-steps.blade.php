<div class="prg">
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Diajukan</span>
    </div>
    <span class="bar done"></span>

    {{-- Upload Pertama Norma Hasil, Akan Diperiksa Ketua Tim --}}
    @if ($usulan->status_norma_hasil == 'diperiksa')
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Menunggu Persetujuan Ketua Tim</span>
    </div>
    <span class="bar half"></span>
    <div class="circle">
        <span class="label"><i class="fa-regular fa-circle"></i></span>
        <span class="title-prg">Menunggu Upload Laporan</span>
    </div>
    <span class="bar half"></span>
    <div class="circle">
        <span class="label"><i class="fa-regular fa-circle"></i></span>
        <span class="title-prg">Verifikasi Arsiparis</span>
    </div>


    {{-- Ketua Tim Accept, Upload /Unggah Dokumen --}}
    @elseif ($usulan->status_norma_hasil == 'disetujui' &&
    ($usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'belum unggah'))
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Disetujui Ketua Tim</span>
    </div>
    <span class="bar done"></span>
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Menunggu Upload Laporan</span>
    </div>
    <span class="bar"></span>
    <div class="circle">
        <span class="label"><i class="fa-regular fa-circle"></i></span>
        <span class="title-prg">Verifikasi Arsiparis</span>
    </div>

    {{-- Sudah Upload, Diperiksa Arsiparis --}}
    @elseif ($usulan->status_norma_hasil == 'disetujui' &&
    ($usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'diperiksa'))
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Disetujui Ketua Tim</span>
    </div>
    <span class="bar done"></span>
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Laporan Telah Diupload</span>
    </div>
    <span class="bar done"></span>
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Menunggu Verifikasi Arsiparis</span>
    </div>

    {{-- Disetujui ALl --}}
    @elseif ($usulan->status_norma_hasil == 'disetujui' &&
    $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'disetujui')
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Disetujui Ketua Tim</span>
    </div>
    <span class="bar done"></span>
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Telah Diverifikasi Arsiparis</span>
    </div>

    {{-- Ditolak Arsiparis --}}
    @elseif ($usulan->status_norma_hasil == 'disetujui' &&
    $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'ditolak')
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Disetujui Ketua Tim</span>
    </div>
    <span class="bar done"></span>
    <div class="circle danger">
        <span class="label"><i class="fa-solid fa-ban"></i></span>
        <span class="title-prg">Norma Hasil Ditolak Arsiparis</span>
    </div>

    {{-- Ditolak Ketua Tim --}}
    @elseif ($usulan->status_norma_hasil == 'ditolak')
    <div class="circle danger">
        <span class="label"><i class="fa-solid fa-ban"></i></span>
        <span class="title-prg">Norma Hasil Ditolak Ketua Tim</span>
    </div>
    <span class="bar half"></span>
    <div class="circle">
        <span class="label"><i class="fa-regular fa-circle"></i></span>
        <span class="title-prg">Verifikasi Arsiparis</span>
    </div>
    @endif


</div>
