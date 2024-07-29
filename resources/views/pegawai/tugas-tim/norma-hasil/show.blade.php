@extends('layouts.app')

@section('title', 'Detail Norma Hasil')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
{{-- Modal --}}
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Norma Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" name="myform" action="/pegawai/tim/norma-hasil/{{ $usulan->id }}"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="jenis" value="{{ $usulan->jenis }}">
                        <label for="alasan">File Laporan</label>
                        <input type="file" name="nama" id="nama" class="form-control" accept=".pdf" required>
                        <small id="error-file" class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-edit">Kirim</button>
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
            <h1>Detail Laporan Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/pegawai/tim/norma-hasil">Laporan Norma Hasil</a></div>
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
                        <div class="row mb-0 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-outline-primary" href="/pegawai/tim/norma-hasil">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </div>

                        @php
                        $status = $usulan->normaHasilAccepted->status_verifikasi_arsiparis ??
                        $usulan->normaHasilDokumen->status_verifikasi_arsiparis;
                        @endphp

                        @include('components.timeline.timeline-nh')
                        <h1 class="h4 text-dark mb-4 header-card">Informasi Laporan Norma Hasil</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Tugas</th>

                                <td>{{ $usulan->rencanaKerja->tugas }}</td>

                                {{-- Status Disetujui --}}
                                {{-- @if ($usulan->status_norma_hasil == 'disetujui') --}}
                            <tr>
                                <th>Nomor Surat</th>

                                <td>
                                    @if ($usulan->jenis == 1)
                                    <span class="badge badge-primary">
                                        R-{{ $usulan->normaHasilAccepted->nomor_norma_hasil}}/{{ $usulan->normaHasilAccepted->unit_kerja}}/{{ $usulan->normaHasilAccepted->kode_klasifikasi_arsip}}/{{ $usulan->normaHasilAccepted->normaHasil->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($usulan->normaHasilAccepted->tanggal_norma_hasil)) }}
                                    </span>
                                    @else
                                    <span class="badge badge-primary">
                                        Dokumen
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            {{-- @endif --}}

                            @if ($usulan->jenis == 1)
                            <tr>
                                <th>Nama Dokumen</th>

                                <td>{{ $usulan->normaHasilAccepted->normaHasil->nama_dokumen }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Usulan</th>

                                <td>{{ $usulan->normaHasilAccepted->normaHasil->tanggal }}</td>
                            </tr>
                            <tr>
                                <th>Draft Norma Hasil</th>

                                <td>
                                    <a target="blank" href="{{ $usulan->normaHasilAccepted->normaHasil->document_path }}" class="badge btn-primary">
                                        <i class="fa fa-solid fa-up-right-from-square mr-1"></i>
                                        Buka Draft Norma Hasil</a>
                                </td>
                            </tr>
                            @endif
                            {{-- @if ($usulan->status_norma_hasil == 'ditolak')
                                            <tr>
                                                <th>Alasan Penolakan</th>

                                                <td>{{ $usulan->catatan_norma_hasil }}</td>
                            </tr>
                            @endif --}}
                            <tr>
                                <th>Norma Hasil Tim</th>

                                <td>
                                    @if ($usulan->jenis == 1)
                                    <a target="blank" href="viewLaporan/{{ $usulan->normaHasilAccepted->id }}/1"
                                        class="badge btn-primary"><i class="fa fa-download mr-1"></i>
                                        Download</a>
                                    @else
                                    <a target="blank" href="viewLaporan/{{ $usulan->normaHasilDokumen->id }}/2"
                                        class="badge btn-primary"><i class="fa fa-download mr-1"></i>
                                        Download</a>
                                    @endif
                                    @if ($status != 'disetujui')
                                    <button type="button" class="ml-2 btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#staticBackdrop">
                                        <i class="fas fa-edit m-0"></i></button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status Verifikasi Arsiparis</th>

                                <td>
                                    <span class="badge
                                                        {{ $status == 'diperiksa' ? 'badge-primary' : '' }}
                                                        {{ $status == 'disetujui' ? 'badge-success' : '' }}
                                                        {{ $status == 'ditolak' ? 'badge-danger' : '' }}
                                                            text-capitalize">{{ $status }}
                                    </span>
                                </td>
                            </tr>
                            @if ($status == 'ditolak')
                            <tr>
                                <th>Alasan Penolakan</th>

                                <td>{{ $usulan->normaHasilAccepted->catatan_arsiparis ?? $usulan->normaHasilDokumen->catatan_arsiparis }}
                                </td>
                            </tr>
                            @endif

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
{{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
{{-- <script src="{{ asset() }}"></script> --}}
{{-- <script src="{{ asset() }}"></script> --}}
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>

<script>
    document.forms['myform'].reset();

    $('.btn-edit').on("click", function (e) {
        if ($('#nama').val() != '' && $('#nama')[0].files[0].size / 1024 > 1024) {
            $('#error-file').text('Ukuran file maksimal 1MB');
            e.preventDefault();
        }
    });
</script>

@endpush
