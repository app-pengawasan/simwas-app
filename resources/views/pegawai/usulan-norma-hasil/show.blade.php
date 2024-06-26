@extends('layouts.app')

@section('title', 'Detail Usulan Norma Hasil')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tolak Norma Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/pegawai/norma-hasil/{{ $usulan->id }}">
                <div class="modal-body">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{ $usulan->id }}">
                    <div class="form-group">
                        <label for="draft">Alasan Penolakan</label>
                        <input placeholder="Berikan Alasan Penolakan" required type="text" class="form-control"
                            name="alasan" id="alasan">
                        @error('alasan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Usulan Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/ketua-tim/norma-hasil">Norma Hasil</a></div>
                <div class="breadcrumb-item">Detail</div>
            </div>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-primary" href="{{ route('ketua-tim.usulan-norma-hasil.index') }}">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        @include('components.timeline.timeline-steps')
                        <h1 class="h4 text-dark mb-4 header-card">Informasi Usulan Norma Hasil</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            @if ($usulan->status_norma_hasil == 'disetujui')
                            <tr>
                                <th>Nomor Surat:</th>
                                <td>
                                    <span class="badge badge-primary">
                                        R-{{ $usulan->normaHasilAccepted->nomor_norma_hasil}}/{{ $usulan->normaHasilAccepted->unit_kerja}}/{{ $usulan->normaHasilAccepted->kode_klasifikasi_arsip}}/{{ $usulan->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($usulan->normaHasilAccepted->tanggal_norma_hasil)) }}
                                    </span>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Tugas:</th>
                                <td>{{ $usulan->rencanaKerja->tugas }}</td>
                            </tr>
                            <tr>
                                <th>Proyek:</th>
                                <td>{{ $usulan->rencanaKerja->proyek->nama_proyek }}</td>
                            </tr>
                            <tr>
                                <th>Tim Kerja:</th>
                                <td>{{ $usulan->rencanaKerja->proyek->timKerja->nama }}</td>
                            </tr>
                            <tr>
                                <th>Nama Dokumen:</th>
                                <td>{{ $usulan->nama_dokumen }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Norma Hasil:</th>
                                <td>{{ $usulan->masterLaporan->nama ?? "" }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Usulan:</th>
                                <td>{{ \Carbon\Carbon::parse($usulan->tanggal)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Objek:</th>
                                <td class="py-2">
                                    @if ($objek->count() == 0)
                                    <span>-</span>
                                    @endif
                                    @foreach ($objek as $objek)
                                    <li>{{ $objek->masterObjek->nama }}
                                        @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Bulan Pelaporan:</th>
                                <td>{{ $usulan->laporanPengawasan ? $month[$usulan->laporanPengawasan->month] : '' }}
                                </td>
                            </tr>
                            @if ($usulan->status_norma_hasil == 'disetujui')
                            <tr>
                                <th>Tanggal Persetujuan Ketua Tim:</th>
                                <td>{{ \Carbon\Carbon::parse($usulan->normaHasilAccepted->tanggal_norma_hasil)->format('d F Y') }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Draft Norma Hasil:</th>
                                <td>
                                    <a target="blank" href="{{ $usulan->document_path }}" class="badge btn-primary"
                                        download>
                                        <i class="fa fa-solid fa-up-right-from-square mr-1"></i>
                                        Buka Draft Norma Hasil
                                    </a>
                                </td>
                            </tr>
                            @if ( $usulan->status_norma_hasil == 'disetujui' &&
                            $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'disetujui')
                            <tr>
                                <th>Laporan Norma Hasil:</th>
                                <td>
                                    <a target="blank" href="{{ asset($usulan->normaHasilAccepted->laporan_path) }}"
                                        class="badge btn-primary" download><i class="fa fa-download"></i> Download</a>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Status Surat:</th>
                                @if ($usulan->status_norma_hasil != 'diperiksa' && $usulan->status_norma_hasil !=
                                'ditolak')
                                <td>
                                    @if ($usulan->normaHasilAccepted->status_verifikasi_arsiparis ==
                                    'belum unggah')
                                    <span class="badge badge-primary">Menunggu Upload Laporan</span>
                                    @elseif ($usulan->normaHasilAccepted->status_verifikasi_arsiparis ==
                                    'diperiksa')
                                    <span class="badge badge-primary">Menunggu Verifikasi
                                        Arsiparis</span>
                                    @elseif ($usulan->normaHasilAccepted->status_verifikasi_arsiparis ==
                                    'disetujui')
                                    <span class="badge badge-success">Norma Hasil Telah Diverifikasi
                                        Arsiparis</span>

                                    @endif
                                </td>
                                @else
                                <td>
                                    <span
                                        class="badge
                                    {{ $usulan->status_norma_hasil == 'diperiksa' ? 'badge-primary' : '' }}
                                    {{ $usulan->status_norma_hasil == 'ditolak' ? 'badge-danger' : '' }}
                                    {{ $usulan->status_norma_hasil == 'disetujui' ? 'badge-success' : '' }}
                                        text-capitalize">{{
                                        $usulan->status_norma_hasil }}
                                    </span>
                                </td>
                                @endif

                            </tr>
                            @if ($usulan->status_norma_hasil == 'ditolak')
                            <tr>
                                <th>Alasan Penolakan:</th>
                                <td>{{ $usulan->catatan_norma_hasil }}</td>
                            </tr>
                            @endif



                        </table>

                        @if ($usulan->status_norma_hasil == 'diperiksa')
                        <div class="d-flex align-content-end w-100 justify-content-end" style="gap: 10px;">
                            <button type="button" class="btn btn-danger tolak-btn" data-toggle="modal"
                                data-target="#staticBackdrop">
                                <i class="fa-regular fa-circle-xmark mr-1"></i>Tolak
                            </button>
                            <form id="setujui" action="{{ route('ketua-tim.usulan-norma-hasil.store', $usulan->id) }}"
                                method="post">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="norma_hasil" value="{{ $usulan->id }}">
                                <button type="submit" class="btn btn-success setujui-btn"><i
                                        class="fa-regular fa-circle-check mr-1"></i>Setujui</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
    $(".setujui-btn").on('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Anda akan menyetujui usulan norma hasil ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#setujui").submit();
            }
        })
    });
</script>
@endpush
