@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
{{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Usulan Surat Srikandi</h1>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="{{ route('usulan-surat-srikandi.index') }}">
                                    <i class="fas fa-chevron-circle-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        @include('components.flash')
                        {{ session()->forget(['alert-type', 'status']) }}
                        <h1 class="h4 text-dark mb-4 header-card">Informasi Pengajuan Surat</h1>
                        <table class="mb-4 table table-striped responsive" id="table-show">
                            <tr>
                                <th>Status Surat:</th>
                                <td>
                                    <span class="badge badge-light">{{ $usulanSuratSrikandi->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Pejabat Penanda Tangan:</th>
                                <td>{{ $usulanSuratSrikandi->pejabat_penanda_tangan }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Naskah Dinas:</th>
                                <td>{{ $usulanSuratSrikandi->jenis_naskah_dinas }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Naskah Dinas Penugasan:</th>
                                <td>{{ $usulanSuratSrikandi->jenis_naskah_dinas_penugasan }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Naskah Dinas Penugasan:</th>
                                <td>{{ $usulanSuratSrikandi->jenis_naskah_dinas_penugasan }}</td>
                            </tr>
                            {{-- kegiatan --}}
                            <tr>
                                <th>Kegiatan:</th>
                                <td>{{ $usulanSuratSrikandi->kegiatan }}</td>
                            </tr>
                            <tr>
                                <th>Derajat Keamanan:</th>
                                <td>{{ $usulanSuratSrikandi->derajat_keamanan }}</td>
                            </tr>
                            <tr>
                                <th>Kode Klasifikasi Arsip:</th>
                                <td>{{ $usulanSuratSrikandi->kode_klasifikasi_arsip }}</td>
                            </tr>
                            <tr>
                                <th>Melaksananan</th>
                                <td>{{ $usulanSuratSrikandi->melaksanakan }}</td>
                            </tr>
                            <tr>
                                <th>Usulan Tanggal Penanda Tangan</th>
                                <td>{{ $usulanSuratSrikandi->usulan_tanggal_penandatanganan }}</td>
                            </tr>
                        </table>
                        {{-- edit and delete button --}}
                        <div class="d-flex">
                            <div class="buttons ml-auto my-2">
                                <a href="{{ route('usulan-surat-srikandi.edit', $usulanSuratSrikandi->id) }}"
                                    id="edit-btn" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <form action="{{ route('usulan-surat-srikandi.destroy', $usulanSuratSrikandi->id) }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" id="delete-btn">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Bootstrap is required -->
@endpush