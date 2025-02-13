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
                        <input type="hidden" name="jenis" value="{{ $usulan->jenis }}">
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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-outline-primary" href="/arsiparis/norma-hasil">
                                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                                </a>
                            </div>
                        </div>

                        @php
                        $status = $usulan->normaHasilAccepted->status_verifikasi_arsiparis ??
                        $usulan->normaHasilDokumen->status_verifikasi_arsiparis;
                        @endphp

                        @include('components.timeline.timeline-nh')
                        <h1 class="h4 text-dark mb-4 header-card" style="margin-top: 100px">Informasi Norma Hasil</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
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
                            <tr>
                                <th>Tugas:</th>
                                <td>{{ $usulan->rencanaKerja->tugas ?? "" }}</td>
                            <tr>
                                <th>Proyek:</th>
                                <td>{{ $usulan->rencanaKerja->proyek->nama_proyek ?? "" }}</td>
                            </tr>
                            <tr>
                                <th>Tim Kerja:</th>
                                <td>{{ $usulan->rencanaKerja->proyek->timKerja->nama ?? "" }}</td>
                            </tr>
                            <tr>
                                <th>Ketua Tim:</th>
                                <td>{{ $usulan->rencanaKerja->proyek->timKerja->ketua->name ?? "" }}</td>
                            </tr>

                            {{-- @endif --}}

                            @if ($usulan->jenis == 1)
                            <tr>
                                <th>Nama Dokumen</th>
                                <td>{{ $usulan->normaHasilAccepted->normaHasil->nama_dokumen }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Norma Hasil:</th>
                                <td>{{ $usulan->normaHasilAccepted->normaHasil->masterLaporan->nama ?? "" }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Usulan</th>
                                <td>{{ \Carbon\Carbon::parse ($usulan->normaHasilAccepted->normaHasil->tanggal)->format('d F Y')  }}
                                </td>
                            </tr>
                            <tr>
                                <th>Draft Norma Hasil</th>

                                <td>
                                    <a target="blank"
                                        href="{{ $usulan->normaHasilAccepted->normaHasil->document_path }}"
                                        class="badge btn-primary">
                                        <i class="fa fa-solid fa-up-right-from-square mr-1"></i>
                                        Buka Draft Norma Hasil</a>
                                </td>
                            </tr>

                            @endif

                            <tr>
                                <th>Norma Hasil Tim</th>
                                <td>
                                    @if ($usulan->jenis == 1)
                                    <a target="blank"
                                        href="/pegawai/tim/norma-hasil/viewLaporan/{{ $usulan->normaHasilAccepted->id }}/1"
                                        class="badge btn-primary"><i class="fa fa-download"></i>
                                        Download Norma Hasil Tim</a>
                                    @else
                                    <a target="blank"
                                        href="/pegawai/tim/norma-hasil/viewLaporan/{{ $usulan->normaHasilDokumen->id }}/2"
                                        class="badge btn-primary"><i class="fa fa-download"></i>
                                        Download Norma Hasil Tim</a>
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
                        @if ($status == 'diperiksa')
                        <div class="d-flex align-content-end w-100 justify-content-end" style="gap: 10px;">
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#staticBackdrop">
                                <i class="fa-regular fa-circle-xmark mr-1"></i>Tolak
                            </button>
                            <form action="/arsiparis/norma-hasil" method="post">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="norma_hasil" value="{{ $usulan->id }}">
                                <input type="hidden" name="jenis" value="{{ $usulan->jenis }}">
                                <button type=" submit" class="btn btn-success"><i
                                        class="fa-regular fa-circle-check mr-1"></i>Setujui</button>
                            </form>
                        </div>
                        @else
                        @if ($usulan->jenis == 1)
                        <div class="d-flex justify-content-end">
                            <a href="/arsiparis/norma-hasil/edit/{{ $usulan->id }}" class="btn btn-warning mt-4">
                                <i class="fa-regular fa-pen-to-square mr-1"></i>
                                Edit</a>
                        </div>
                        @endif
                        @endif

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