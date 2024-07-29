@extends('layouts.app')

@section('title', 'Usulan Norma Hasil')

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
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Usulan Norma Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Usulan Norma Hasil</div>
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
                                        <select name="year" id="yearSelect" class="form-control select2">
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
                                    <label for="filter-surat" style="margin-bottom: 0;">
                                        Jenis</label>
                                    <select name="jabatan" id="filter-surat" class="form-control select2">
                                        <option value="">Semua</option>
                                        @foreach ($jenisNormaHasil as $key => $value)
                                        <option value="{{ $value }}" {{ request()->jabatan == $key ? 'selected' : '' }}>
                                            {{ $value }}
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
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display responsive"
                                    id="table-norma-hasil">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; text-align:center">No</th>
                                            <th>Nama Pengusul</th>
                                            <th style="width: 180px;">Nomor Surat</th>
                                            <th style="width: 170px;">Jenis Norma Hasil</th>
                                            <th style="width: 120px;">Tanggal Usulan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usulan as $un)
                                        <tr>
                                            <td style="text-align:center">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="capitalize">
                                                <div
                                                    class="d-flex flex-row text-capitalize align-items-center jutify-content-center">

                                                    {{  $un->user->name ?? "" }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($un->status_norma_hasil == 'disetujui')
                                                <span class="badge badge-primary">
                                                    R-{{ $un->normaHasilAccepted->nomor_norma_hasil ?? ''}}/{{ $un->normaHasilAccepted->unit_kerja ?? ''}}/{{ $un->normaHasilAccepted->kode_klasifikasi_arsip ?? ''}}/{{ $un->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($un->normaHasilAccepted->tanggal_norma_hasil ?? '')) }}
                                                </span>
                                                @endif
                                            </td>
                                            <td>{{ $un->masterLaporan->nama ?? "" }}</td>
                                            <td>{{ date('d F Y', strtotime($un->tanggal)) }}</td>
                                            @if ($un->status_norma_hasil != 'diperiksa' && $un->status_norma_hasil
                                            !=
                                            'ditolak')
                                            <td>
                                                @if ($un->normaHasilAccepted->status_verifikasi_arsiparis ==
                                                'belum unggah')
                                                <span class="badge badge-dark">Menunggu Upload Laporan</span>
                                                @elseif ($un->normaHasilAccepted->status_verifikasi_arsiparis ==
                                                'diperiksa')
                                                <span class="badge badge-dark"><i
                                                        class="fa-regular fa-clock mr-1"></i>Diperiksa
                                                    Arsiparis</span>
                                                @elseif ($un->normaHasilAccepted->status_verifikasi_arsiparis ==
                                                'disetujui')
                                                <span class="badge badge-success"><i
                                                        class="fa-regular fa-circle-check mr-1"></i>Disetujui
                                                    Arsiparis</span>
                                                @endif
                                            </td>
                                            @else
                                            <td>
                                                <span class="badge
                                                    {{ $un->status_norma_hasil == 'diperiksa' ? 'badge-warning' : '' }}
                                                    {{ $un->status_norma_hasil == 'ditolak' ? 'badge-danger' : '' }}
                                                    {{ $un->status_norma_hasil == 'disetujui' ? 'badge-success' : '' }}
                                                        text-capitalize">
                                                    @if ($un->status_norma_hasil == 'diperiksa')<i
                                                        class="fa-regular fa-clock mr-1"></i>
                                                    @elseif ($un->status_norma_hasil == 'ditolak')<i
                                                        class="fa-solid fa-triangle-exclamation mr-1"></i>
                                                    @elseif ($un->status_norma_hasil == 'disetujui')<i
                                                        class="fa-regular fa-circle-check mr-1"></i>
                                                    @endif

                                                    {{$un->status_norma_hasil }}
                                                </span>
                                            </td>
                                            @endif
                                            <td>
                                                <a href="{{ route('ketua-tim.usulan-norma-hasil.show', $un->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye
                                                    "></i>
                                                </a>
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

<script src="{{ asset('js') }}/page/pegawai/usulan-norma-hasil.js"></script>
@endpush
