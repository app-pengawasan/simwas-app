<div class="prg">
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Surat Tugas Diajukan</span>
    </div>
    <span class="bar done"></span>

    @if ($surat->status == 'diperiksa')
    <div class="circle active">
        <span class="label"><i class="fa-solid fa-hourglass-start"></i></span>
        <span class="title-prg">Menunggu Persetujuan Arsiparis</span>
    </div>

    @elseif ($surat->status == 'disetujui')
    <div class="circle done">
        <span class="label"><i class="fa-solid fa-check"></i></span>
        <span class="title-prg">Surat Tugas Disetujui Arsiparis</span>
    </div>

    @elseif ($surat->status == 'ditolak')
    <div class="circle danger">
        <span class="label"><i class="fa-solid fa-ban"></i></span>
        <span class="title-prg">Surat Tugas Ditolak Arsiparis</span>
    </div>
    @endif

</div>
