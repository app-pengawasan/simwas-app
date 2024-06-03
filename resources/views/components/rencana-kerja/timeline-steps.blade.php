<div class="prg">
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Rencana Kegiatan Berhasil Dibuat</span>
    </div>

    @if ($timKerja->status == 0 || $timKerja->status == 1)
    <span class="bar done"></span>
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Dalam Proses Penyusunan Oleh Ketua Tim</span>
    </div>
    <span class="bar half"></span>
    <div class="circle">
        <span class="label"><i class="fa-regular fa-circle"></i></span>
        <span class="title-prg">Persetujuan Oleh Perencana</span>
    </div>
    @endif
    @if ($timKerja->status == 2 || $timKerja->status == 4)
    <span class="bar done"></span>
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Ketua Tim Telah Selesai Menyusun Rencana Kegiatan</span>
    </div>
    <span class="bar done"></span>
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Menunggu Persetujuan Oleh Perencana</span>
    </div>
    @endif

    @if ($timKerja->status == 3)
    <span class="bar done"></span>
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Ketua Tim Telah Selesai Menyusun Rencana Kegiatan</span>
    </div>
    <span class="bar done"></span>
    <div class="circle warning">
        <span class="label"><i class="fa-solid fa-triangle-exclamation"></i></span>
        <span class="title-prg">Rencana Kinerja Ditolak, Silakan Perbaiki</span>
    </div>
    @endif


    @if ($timKerja->status == 5)
    <span class="bar done"></span>
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Ketua Tim Telah Selesai Menyusun Rencana Kegiatan</span>
    </div>
    <span class="bar done"></span>
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Rencana Kinerja Disetujui Oleh Perencana</span>
    </div>
    @endif

    {{--
    @elseif ($usulan->status_norma_hasil == 'disetujui' &&
    $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'diperiksa')
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Norma Hasil Disetujui Ketua Tim</span>
    </div>
    <span class="bar done"></span>
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Menunggu Verifikasi Arsiparis</span>
    </div>

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
    @endif --}}


</div>
