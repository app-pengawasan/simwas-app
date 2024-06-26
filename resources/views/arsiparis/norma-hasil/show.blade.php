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
                <h5 class="modal-title" id="staticBackdropLabel">Tolak Norma Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/arsiparis/norma-hasil/{{ $usulan->id }}">
                <div class="modal-body">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="alasan">Alasan Penolakan</label>
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.arsiparis-header')
@include('components.arsiparis-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/arsiparis/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/arsiparis/norma-hasil">Laporan Norma Hasil</a></div>
                <div class="breadcrumb-item">Detail</div>
            </div>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="col-md-4 mb-4">
                                            <a class="btn btn-primary" href="/arsiparis/norma-hasil">
                                                <i class="fas fa-chevron-circle-left"></i> Kembali
                                            </a>
                                        </div>

                                        @include('components.timeline.timeline-steps')

                                        <table class="table">
                                            <tr>
                                                <th>Tugas</th>
                                                <th>:</th>
                                                <td>{{ $usulan->rencanaKerja->tugas }}</td>

                                                {{-- Status Disetujui --}}
                                                @if ($usulan->status_norma_hasil == 'disetujui')
                                            <tr>
                                                <th>Nomor Surat</th>
                                                <th>:</th>
                                                <td>
                                                    <span class="badge badge-primary">
                                                        R-{{ $usulan->normaHasilAccepted->nomor_norma_hasil}}/{{ $usulan->normaHasilAccepted->unit_kerja}}/{{ $usulan->normaHasilAccepted->kode_klasifikasi_arsip}}/{{
                                                        $kodeHasilPengawasan[$usulan->normaHasilAccepted->kode_norma_hasil]}}/{{ date('Y', strtotime($usulan->normaHasilAccepted->tanggal_norma_hasil)) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <th>Nama Dokumen</th>
                                                <th>:</th>
                                                <td>{{ $usulan->nama_dokumen }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Usulan</th>
                                                <th>:</th>
                                                <td>{{ $usulan->tanggal }}</td>
                                            </tr>
                                            <tr>
                                                <th>Draft Norma Hasil</th>
                                                <th>:</th>
                                                <td>
                                                    <a target="blank" href="{{ $usulan->document_path }}"
                                                        class="badge btn-primary" download>
                                                        <i class="fa fa-solid fa-up-right-from-square mr-1"></i>
                                                        Buka Draft Norma Hasil
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Laporan Norma Hasil</th>
                                                <th>:</th>
                                                <td>
                                                    <a target="blank"
                                                        href="{{ asset($usulan->normaHasilAccepted->laporan_path) }}"
                                                        class="badge btn-primary" download><i
                                                            class="fa fa-download"></i> Download</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status Verifikasi Arsiparis</th>
                                                <th>:</th>
                                                <td>
                                                    <span
                                                        class="badge
                                                        {{ $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'diperiksa' ? 'badge-primary' : '' }}
                                                        {{ $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'disetujui' ? 'badge-success' : '' }}
                                                        {{ $usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'ditolak' ? 'badge-danger' : '' }}
                                                            text-capitalize">{{ $usulan->normaHasilAccepted->status_verifikasi_arsiparis }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'ditolak')
                                            <tr>
                                                <th>Alasan Penolakan</th>
                                                <th>:</th>
                                                <td>{{ $usulan->normaHasilAccepted->catatan_arsiparis }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                    @if ($usulan->normaHasilAccepted->status_verifikasi_arsiparis == 'diperiksa')
                                    <div class="d-flex align-content-end w-100 justify-content-end" style="gap: 10px;">
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#staticBackdrop">
                                            Tolak
                                        </button>
                                        <form action="/arsiparis/norma-hasil" method="post">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="norma_hasil" value="{{ $usulan->id }}">
                                            <button type=" submit" class="btn btn-success">Setujui</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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

@endpush