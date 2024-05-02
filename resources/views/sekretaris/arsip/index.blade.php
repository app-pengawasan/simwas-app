@extends('layouts.app')

@section('title', 'Usulan Surat Srikandi')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.sekretaris-header')
@include('components.sekretaris-sidebar')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Usulan Surat Srikandi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/sekretaris/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active">Usulan Surat Srikandi</div>
            </div>
        </div>
        @include('components.flash')
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div>
                            <form action="{{ route('usulan-surat-srikandi.index') }}" method="GET">
                                <div class="d-flex justify-content-between flex-wrap" style="gap:10px">
                                    <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                        <label for="filter-search" style="margin-bottom: 0;">
                                            Cari</label>
                                        <input style="height: 35px" type="text" name="search" id="filter-search"
                                            class="form-control" placeholder="Cari berdasarkan nomor surat"
                                            value="{{ request()->search }}">
                                    </div>
                                    {{-- filter unit_kerja --}}
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label for="filter-unit_kerja" style="margin-bottom: 0;">Unit Kerja</label>
                                        <select name="filter-unit_kerja" id="filter-unit_kerja"
                                            class="form-control select2">
                                            <option disabled value="">Pilih Unit Kerja</option>
                                            <option value="Semua">Semua</option>
                                            @foreach ( $pejabatPenandatangan as $key => $value)
                                            <option value="{{ $value }}">
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        {{-- select year --}}
                                        <label for="filter-year" style="margin-bottom: 0;">Tahun</label>
                                        <select name="filter-year" id="filter-year" class="form-control select2">
                                            <option disabled value="">Pilih Tahun</option>
                                            <option value="Semua">Semua</option>
                                            @foreach ( $allYears as $year)
                                            <option value="{{ $year->year }}">
                                                {{ $year->year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="">
                            <table id="table-usulan-surat-srikandi"
                                class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">No</th>
                                        <th>Nomor Surat</th>
                                        <th>Nama Pengaju</th>
                                        <th>Tanggal Persetujuan Srikandi</th>
                                        <th>Unit Kerja</th>
                                        <th>Link Srikandi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($suratSrikandi as $usulan)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ $usulan->nomor_surat_srikandi }}</span>
                                        </td>
                                        <td class="text-capitalize">
                                            <div
                                                class="d-flex flex-row text-capitalize align-items-center jutify-content-center">
                                                <div class="circle mr-2">
                                                    <span class="initials text-capitalize">
                                                        {{ substr($usulan->usulanSuratSrikandi->user->name, 0, 1) }}{{ substr(strstr($usulan->usulanSuratSrikandi->user->name, ' '), 1, 1) }}
                                                    </span>
                                                </div>
                                                {{  $usulan->usulanSuratSrikandi->user->name }}
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($usulan->tanggal_persetujuan_srikandi)->format('d F Y') }}
                                        </td>
                                        <td>{{ $usulan->kepala_unit_penandatangan_srikandi }}</td>
                                        <td>
                                            <a target="_blank" class="badge badge-primary"
                                                href="{{ $usulan->link_srikandi }}">
                                                <i class="fa-solid fa-link mr-1"></i>
                                                Buka Link Srikandi</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('surat-srikandi.show', $usulan->id_usulan_surat_srikandi) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye
                                                "></i>
                                                Detail
                                            </a>
                                            <a href="{{ route('surat-srikandi.download', $usulan->id_usulan_surat_srikandi) }}"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Download Surat Srikandi">
                                                <i class="fa-solid fa-file-pdf"></i>
                                                Download
                                        </td>
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

{{-- <script src="{{ asset('js/page/pegawai/usulan-surat-srikandi/index.js') }}"></script> --}}
<script>
    let table = $("#table-usulan-surat-srikandi")
    .dataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    buttons: [
    ],
    })
    .api();

    function filterTable() {
    let filterYear = $("#filter-year").val();
    let filterStatus = $("#filter-status").val();
    let filterSurat = $("#filter-surat").val();
    let filterSearch = $("#filter-search").val();
    let filterUnitKerja = $("#filter-unit_kerja").val();


    if (filterStatus === "Semua") {
    filterStatus = "";
    }
    if (filterSurat === "Semua") {
    filterSurat = "";
    }
    if (filterYear === "Semua") {
    filterYear = "";
    }
    if (filterUnitKerja === "Semua") {
    filterUnitKerja = "";
    }

    table
    .column(1)
    .search(filterSearch, true, false)
    .column(3)
    .search(filterYear, true, false)
    .column(4)
    .search(filterUnitKerja, true, false)
    .draw();

    // reset numbering in table first column
    table
    .column(0, { search: "applied", order: "applied" })
    .nodes()
    .each(function (cell, i) {
    cell.innerHTML = i + 1;
    });
    }

    $("#filter-year, #filter-status, #filter-unit_kerja").on("change", function () {
    filterTable();
    });
    $("#filter-search").on("keyup", function () {
        console.log('test');
    filterTable();
    });
    filterTable();
    $(".dataTables_filter").hide();
</script>
@endpush