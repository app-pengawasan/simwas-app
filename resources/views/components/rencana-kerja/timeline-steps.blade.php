<div class="prg" style="margin-bottom: 40px">
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Rencana Kegiatan Berhasil Dibuat</span>
    </div>

    @if ($timKerja->status == 0 || $timKerja->status == 1)
        <span class="bar done"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Dalam Proses Penyusunan Oleh PJ Kegiatan</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Rencana Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Rencana Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Admin Memulai Pelaksanaan PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="vertbar half" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="bar half"></span>
        <span class="bar half" style="width: 40px"></span>
        <span class="vertbar half" style="bottom: 47.5px"></span>
    @endif
    {{-- @if ($timKerja->status == 1)
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
    @endif --}}


    @if ($timKerja->status == 2)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Persetujuan Rencana Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Rencana Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Admin Memulai Pelaksanaan PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="vertbar half" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="bar half"></span>
        <span class="bar half" style="width: 40px"></span>
        <span class="vertbar half" style="bottom: 47.5px"></span>
    @endif


    @if ($timKerja->status == 3)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Persetujuan Rencana Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Admin Memulai Pelaksanaan PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="vertbar half" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="bar half"></span>
        <span class="bar half" style="width: 40px"></span>
        <span class="vertbar half" style="bottom: 47.5px"></span>
    @endif


    @if ($timKerja->status == 4)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Pelaksanaan PKPT Dimulai Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <span class="vertbar half" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar half"></span>
        <span class="bar half"></span>
        <span class="bar half" style="width: 40px"></span>
        <span class="vertbar half" style="bottom: 47.5px"></span>
    {{-- <span class="bar done"></span>
    <div class="circle danger">
        <span class="label"><i class="fa-solid fa-triangle-exclamation"></i></span>
        <span class="title-prg">Rencana Kinerja Ditolak, Silakan Perbaiki</span>
    </div> --}}
    @endif

    @if ($timKerja->status == 5)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Pelaksanaan PKPT Dimulai Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <span class="vertbar done" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar done"></span>
        <span class="bar done"></span>
        <span class="bar done" style="width: 40px"></span>
        <span class="vertbar done" style="bottom: 47.5px"></span>
    @endif

    @if ($timKerja->status == 6)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Pelaksanaan PKPT Dimulai Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <span class="vertbar done" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar half"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Persetujuan Realisasi Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar done"></span>
        <span class="bar done"></span>
        <span class="bar done" style="width: 40px"></span>
        <span class="vertbar done" style="bottom: 47.5px"></span>
    @endif

    @if ($timKerja->status == 7)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Pelaksanaan PKPT Dimulai Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <span class="vertbar done" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle">
            <span class="label"><i class="fa-regular fa-circle"></i></span>
            <span class="title-prg">Penyelesaian PKPT Oleh Admin</span>
        </div>
        <span class="bar half"></span>
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Persetujuan Realisasi Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Realisasi Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar done"></span>
        <span class="bar done"></span>
        <span class="bar done" style="width: 40px"></span>
        <span class="vertbar done" style="bottom: 47.5px"></span>
    @endif

    @if ($timKerja->status == 8)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Pelaksanaan PKPT Dimulai Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <span class="vertbar done" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Admin Menyelesaikan PKPT</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Realisasi Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Realisasi Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar done"></span>
        <span class="bar done"></span>
        <span class="bar done" style="width: 40px"></span>
        <span class="vertbar done" style="bottom: 47.5px"></span>
    @endif

    @if ($timKerja->status == 9)
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK Telah Selesai Menyusun Rencana Kegiatan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Rencana Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Pelaksanaan PKPT Dimulai Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <span class="vertbar done" style="top: 47.5px"></span>
    </div>
    <div class="prg" style="margin-bottom: 80px"> 
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PKPT Diselesaikan Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Realisasi Kinerja Disetujui Oleh Inspektur</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Realisasi Kinerja Disetujui Oleh Admin</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">PJK mengirim Selesai PKPT</span>
        </div>
        <span class="bar done"></span>
        <span class="bar done"></span>
        <span class="bar done" style="width: 40px"></span>
        <span class="vertbar done" style="bottom: 47.5px"></span>
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