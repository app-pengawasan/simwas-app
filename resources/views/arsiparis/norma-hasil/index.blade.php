@extends('layouts.app')

@section('title', 'Norma Hasil')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <meta name="base-url" content="{{ route('master-pegawai.destroy', ':id') }}"> --}}
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.arsiparis-header')
@include('components.arsiparis-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/arsiparis">Dashboard</a></div>
                <div class="breadcrumb-item">Norma Hasil</div>
            </div>
        </div>

        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="mb-3">
                                    <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                    Halaman ini menampilkan daftar usulan norma hasil yang diajukan oleh pegawai.
                                </p>
                                <div id="download-button">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                                <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                    <div id="filter-search-wrapper">
                                    </div>
                                </div>
                                {{-- tahun from $tahun --}}
                                <form id="yearForm" action="" method="GET">
                                    @csrf
                                    <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                        <label for="filter-tahun" style="margin-bottom: 0;">
                                            Tahun</label>
                                        <select name="year" id="filter-tahun" class="form-control select2">
                                            @foreach ($year as $key => $value)
                                            <option value="{{ $value->year }}"
                                                {{ request()->query('year') == $value->year ? 'selected' : '' }}>
                                                {{ $value->year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                                <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                    <label for="filter-unit-kerja" style="margin-bottom: 0;">
                                        Unit Kerja</label>
                                    <select name="unit_kerja" id="filter-unit-kerja" class="form-control select2">
                                        <option value="">Semua</option>
                                        @foreach ($unit_kerja as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ request()->unit_kerja == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                    <label for="filter-surat" style="margin-bottom: 0;">
                                        Jenis</label>
                                    <select name="jabatan" id="filter-surat" class="form-control select2">
                                        <option value="">Semua</option>
                                        @foreach ($jenisNormaHasil as $key => $value)
                                        <option value="{{ $value->nama }}">
                                            {{ $value->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- status,diperiksa, ditolak, disetujui --}}
                                <div class="form-group
                                                                                            {{ request()->status ? 'd-none' : '' }}"
                                    style="margin-bottom: 0; max-width: 200px;">
                                    <label for="filter-status" style="margin-bottom: 0;">
                                        Status</label>
                                    <select name="status" id="filter-status" class="form-control select2">
                                        <option value="">Semua</option>
                                        <option value="diperiksa"
                                            {{ request()->status == 'diperiksa' ? 'selected' : '' }}>
                                            Diperiksa
                                        </option>
                                        <option value="ditolak" {{ request()->status == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                        <option value="disetujui"
                                            {{ request()->status == 'disetujui' ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                        {{-- belum upload --}}
                                        <option value="belum upload"
                                            {{ request()->status == 'belum-upload' ? 'selected' : '' }}>
                                            Belum Upload
                                        </option>


                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display responsive"
                                    id="table-norma-hasil">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; text-align:center">No</th>
                                            <th>Tugas</th>
                                            <th>Nomor Dokumen</th>
                                            <th>Jenis</th>
                                            <th>Objek Pengawasan</th>
                                            <th>Bulan Pelaporan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                            <th class="never">tahun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporan as $lnm)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $lnm->rencanaKerja->tugas ?? "" }}</td>
                                            <td>
                                                @if ($lnm->jenis == 1)
                                                <span class="badge badge-primary">
                                                    R-{{ $lnm->normaHasilAccepted->nomor_norma_hasil}}/{{ $lnm->normaHasilAccepted->unit_kerja}}/{{ $lnm->normaHasilAccepted->kode_klasifikasi_arsip}}/{{ $lnm->normaHasilAccepted->normaHasil->masterLaporan->kode?? $lnm->normaHasilAccepted->kode_norma_hasil ?? "" }}/{{ date('Y', strtotime($lnm->normaHasilAccepted->tanggal_norma_hasil)) }}
                                                </span>
                                                @else
                                                <span class="badge badge-primary">
                                                    Dokumen
                                                </span>
                                                @endif
                                            </td>
                                            <td>{{ $lnm->normaHasilAccepted->normaHasil->masterLaporan->nama ?? $lnm->normaHasilAccepted->kode_norma_hasil ?? "" }}
                                            </td>
                                            <td>{{ $lnm->normaHasilAccepted->normaHasil->laporanPengawasan->objekPengawasan->nama ??
                                                    $lnm->normaHasilDokumen->laporanPengawasan->objekPengawasan->nama ?? "" }}
                                            </td>
                                            <td>{{ $months[$lnm->normaHasilAccepted->normaHasil->laporanPengawasan->month ?? $lnm->normaHasilDokumen->laporanPengawasan->month ?? 0] }}
                                            </td>
                                            <td>
                                                @php
                                                $status = $lnm->normaHasilAccepted->status_verifikasi_arsiparis ??
                                                $lnm->normaHasilDokumen->status_verifikasi_arsiparis;
                                                @endphp
                                                <span class="badge
                                                    {{ $status == 'diperiksa' ? 'badge-primary' : '' }}
                                                    {{ $status == 'disetujui' ? 'badge-success' : '' }}
                                                    {{ $status == 'ditolak' ? 'badge-danger' : '' }}
                                                    text-capitalize"><i class="
                                                        {{ $status == 'diperiksa' ? 'fa-regular fa-clock mr-1' : '' }}
                                                        {{ $status == 'disetujui' ? 'fa-regular fa-circle-check mr-1' : '' }}
                                                        {{ $status == 'ditolak' ? 'fa-solid fa-triangle-exclamation mr-1' : '' }}
                                                    "></i>{{ $status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/arsiparis/norma-hasil/{{ $lnm->id }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye
                                                    "></i>
                                                </a>
                                            </td>
                                            <td>{{ substr($lnm->tanggal_norma_hasil, 0, 4) }}</td>
                                        </tr>
                                        @endforeach
                                        @foreach ($normaHasilBelumUpload as $normaHasil)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration + count($laporan) }}
                                            </td>
                                            <td>{{ $normaHasil->normaHasil->rencanaKerja->tugas }}</td>
                                            <td>
                                                <span class="badge badge-primary">
                                                    R-{{ $normaHasil->nomor_norma_hasil}}/{{ $normaHasil->unit_kerja}}/{{ $normaHasil->kode_klasifikasi_arsip}}/{{ $normaHasil->normaHasil->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($normaHasil->tanggal_norma_hasil)) }}
                                                </span>
                                            </td>
                                            <td>{{ $normaHasil->normaHasil->masterLaporan->nama ?? "" }}</td>
                                            <td>
                                                {{ $normaHasil->normaHasil->laporanPengawasan->objekPengawasan->nama ?? "" }}
                                            </td>
                                            <td>
                                                {{ $months[$normaHasil->normaHasil->laporanPengawasan->month?? 0] }}
                                            </td>
                                            <td><span class="badge badge-warning">
                                                    Belum Upload
                                                </span></td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
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
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js') }}/page/arsiparis/norma-hasil.js"></script>
@endpush
