@extends('layouts.app')

@section('title', 'Kelola Rencana Kinerja')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Modal -->
    <section class="section">
        <div class="section-header">
            <h1>Kelola Rencana Kinerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Kelola Rencana Kinerja</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p>
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Halaman untuk mengelola rencana kinerja yang didelegasikan.
                            </p>
                            <div id="download-button">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                            <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                <div id="filter-search-wrapper">
                                </div>
                            </div>

                            <form id="yearForm" action="" method="GET">
                                @csrf
                                <div class="form-group" style="margin-bottom: 0; max-width: 200px;">
                                    <label for="filter-tahun" style="margin-bottom: 0;">
                                        Tahun</label>
                                    @php
                                    $currentYear = date('Y');
                                    $selectedYear = request()->query('year', $currentYear);
                                    @endphp

                                    <select name="year" id="yearSelect" class="form-control select2">
                                        @foreach ($year as $key => $value)
                                        <option value="{{ $value->tahun }}"
                                            {{ $selectedYear == $value->tahun ? 'selected' : '' }}>
                                            {{ $value->tahun }}
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
                                    <option value="{{ $value }}" {{ request()->unit_kerja == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <table id="tim-kerja" class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 15px;">No</th>
                                        <th>Tahun</th>
                                        <th>Unit Kerja</th>
                                        <th style="width: 400px;">IKU</th>
                                        <th>Kegiatan</th>
                                        <th>PJ Kegiatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timKerja as $tim)
                                    <tr id="index_{{ $tim->id_timkerja }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $tim->tahun }}</td>
                                        <td>{{ $unitKerja[$tim->unitkerja] }}</td>
                                        <td>{{ $tim->iku->iku }}</td>
                                        <td>{{ $tim->nama }}</td>
                                        <td>
                                            <div
                                                class="d-flex flex-row text-capitalize align-items-center jutify-content-center">

                                                {{  $tim->ketua->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $colorText[$tim->status] }}">{{ $statusTim[$tim->status] }}</span>
                                        </td>
                                        <td>
                                            <a href="/ketua-tim/rencana-kinerja/{{ $tim->id_timkerja }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
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
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
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

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/pegawai/ketua-tim-rencana-kinerja.js') }}"></script>
@endpush