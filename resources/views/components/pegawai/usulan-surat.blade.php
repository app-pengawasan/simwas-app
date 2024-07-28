<div class="card col-md-12 p-0 pr-2">
    <div class="card-body shadow-sm border p-4">
        <div class="h4 text-dark mb-4 d-flex align-items-center header-card">
            <div class="badge alert-warning mr-2 d-flex justify-content-center align-items-center"
                style="width: 30px; height: 30px">
                <i class="fa-regular fa-paper-plane fa-xs"></i>
            </div>
            <h1 class="h4 text-dark mb-0">
                Informasi Pengajuan Surat
            </h1>
        </div>
        <table class="mb-4 table table-striped responsive" id="table-show">
            <tr>
                <th>Status Surat:</th>
                <td>
                    @if ($usulanSuratSrikandi->status == 'disetujui')
                    <span class="badge badge-success mr-1"><i
                            class="fa-regular fa-circle-check mr-1"></i>Disetujui</span>
                    Pada Tanggal {{ $usulanSuratSrikandi->updated_at->format('d F Y')}}
                    @elseif ($usulanSuratSrikandi->status == 'ditolak')
                    <span class="badge badge-danger"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Ditolak</span>
                    @elseif ($usulanSuratSrikandi->status == 'dibatalkan')
                    <span class="badge badge-danger"><i class="fa-solid fa-ban mr-1"></i>Dibatalkan</span>
                    @else
                    <span class="badge badge-light"><i class="fa-regular fa-clock mr-1"></i>Menunggu</span>
                    @endif
                </td>
            </tr>
            @if ($usulanSuratSrikandi->status == 'ditolak')
            <tr>
                <th>Alasan Ditolak:</th>
                <td> <span class="text-dark badge ">{{ $usulanSuratSrikandi->catatan }}</span>
                </td>
            </tr>
            @endif
            <tr>

                <th>Dokumen Surat Usulan:</th>
                <td>
                    <a class="badge badge-primary p-2" href="/{{ $usulanSuratSrikandi->directory }}">
                        <i class="fa-solid fa-file-arrow-down mr-1"></i>Download</a>
                </td>
            </tr>
            <tr>
                <th>Tanggal Pengajuan:</th>
                <td>{{ \Carbon\Carbon::parse($usulanSuratSrikandi->created_at)->format('d F Y') }}
                </td>
            </tr>
            <tr>
                <th>Pejabat Penanda Tangan:</th>
                <td>{{ $pejabatPenandaTangan[$usulanSuratSrikandi->pejabat_penanda_tangan] }}
                </td>
            </tr>
            <tr>
                <th>Jenis Naskah Dinas:</th>
                <td>{{ $jenisNaskahDinas[$usulanSuratSrikandi->jenis_naskah_dinas] }}</td>
            </tr>
            @if($usulanSuratSrikandi->jenis_naskah_dinas_penugasan != null)
            <tr>
                <th>Jenis Naskah Dinas Penugasan:</th>
                <td>{{ $jenisNaskahDinasPenugasan[$usulanSuratSrikandi->jenis_naskah_dinas_penugasan] }}
                </td>
            </tr>
            @endif
            @if ($usulanSuratSrikandi->jenis_naskah_dinas_korespondensi != null)
            <tr>
                <th>Jenis Naskah Dinas Korespondensi:</th>
                <td>{{ $jenisNaskahDinasKorespondensi[$usulanSuratSrikandi->jenis_naskah_dinas_korespondensi] }}
                </td>
            </tr>
            @endif
            @if ($usulanSuratSrikandi->kegiatan!= null)
            <tr>
                <th>Kegiatan:</th>
                <td>{{ $kegiatan[$usulanSuratSrikandi->kegiatan] }}</td>
            </tr>
            @endif
            @if($usulanSuratSrikandi->melaksanakan != null)
            <tr>
                <th>Melaksananan</th>
                <td>{{ $usulanSuratSrikandi->melaksanakan }}</td>
            </tr>
            @endif
            @if($usulanSuratSrikandi->kegiatan_pengawasan != null)
            <tr>
                <th>Kegiatan Pengawasan:</th>
                <td>{{ $kegiatanPengawasan[$usulanSuratSrikandi->kegiatan_pengawasan] }}</td>
            </tr>
            @endif
            @if($usulanSuratSrikandi->pendukung_pengawasan != null)
            <tr>
                <th>Pendukung Pengawasan:</th>
                <td>{{ $pendukungPengawasan[$usulanSuratSrikandi->pendukung_pengawasan] }}</td>
            </tr>
            @endif
            @if($usulanSuratSrikandi->unsur_tugas != null)
            <tr>
                <th>Unsur Tugas:</th>
                <td>{{ $unsurTugas[$usulanSuratSrikandi->unsur_tugas] }}</td>
            </tr>
            @endif
            @if($usulanSuratSrikandi->perihal != null)
            <tr>
                <th>Perihal:</th>
                <td>{{ $usulanSuratSrikandi->perihal }}</td>
            </tr>
            @endif

            <tr>
                <th>Derajat Keamanan:</th>
                <td>{{ $usulanSuratSrikandi->derajat_keamanan }}</td>
            </tr>
            <tr>
                <th>Kode Klasifikasi Arsip:</th>
                <td>{{ $usulanSuratSrikandi->kodeKlasifikasiArsip->kode ?? '' }}
                    {{ $usulanSuratSrikandi->kodeKlasifikasiArsip->uraian ?? '' }}
                </td>
            </tr>

            <tr>
                <th>Usulan Tanggal Penanda Tangan</th>
                <td>{{ \Carbon\Carbon::parse($usulanSuratSrikandi->usulan_tanggal_penandatanganan)->format('d F Y') }}
                </td>
            </tr>
        </table>
    </div>
</div>