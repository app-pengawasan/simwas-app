<div class="prg">

    @if ($usulan->jenis == 1)
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Norma Hasil Diajukan</span>
        </div>
        <span class="bar done"></span>
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Norma Hasil Disetujui Ketua Tim</span>
        </div>
        <span class="bar done"></span>
    @endif
    
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Laporan Telah Diupload</span>
    </div>
    <span class="bar done"></span>

    {{-- Sudah Upload, Diperiksa Arsiparis --}}
    @if ($status == 'diperiksa')
        <div class="circle active">
            <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
            <span class="title-prg">Menunggu Verifikasi Arsiparis</span>
        </div>

    {{-- Disetujui ALl --}}
    @elseif ($status == 'disetujui')
        <div class="circle done">
            <span class="label"><i class="fa-solid fa-check"></i></span>
            <span class="title-prg">Norma Hasil Telah Diverifikasi Arsiparis</span>
        </div>

    {{-- Ditolak Arsiparis --}}
    @elseif ($status == 'ditolak')
        <div class="circle danger">
            <span class="label"><i class="fa-solid fa-ban"></i></span>
            <span class="title-prg">Norma Hasil Ditolak Arsiparis</span>
        </div>

    @endif


</div>
