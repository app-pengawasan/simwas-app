@extends('layouts.app')

@section('title', 'Target IKU Unit Kerja')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
@include('components.perencana-header')
@include('components.perencana-sidebar')
<div class="main-content">
    <!-- Modal -->

    <section class="section">
        <div class="section-header">
            <h1>Kelola Target IKU Unit Kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/perencana">Dashboard</a></div>
                <div class="breadcrumb-item">Target IKU Unit Kerja</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash')
                        <div class="d-flex justify-content-between">
                            <p>
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Halaman Mengelola Target Indikator Kinerja Utama Unit Kerja.
                            </p>
                            <div id="download-button">
                            </div>
                        </div>
                        {{ session()->forget(['alert-type', 'status']) }}
                        <div class="d-flex justify-content-between flex-wrap my-2 mb-3" style="gap:10px">
                            <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                <div id="filter-search-wrapper">
                                </div>
                            </div>
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
                            {{-- status filter --}}
                            <div class="form-group
                                {{ request()->status ? 'd-none' : '' }}" style="margin-bottom: 0; max-width: 200px;">
                                <label for="filter-status" style="margin-bottom: 0;">
                                    Status</label>
                                <select name="status" id="filter-status" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($status as $key => $value)
                                    <option value="{{ $value }}" {{ request()->status == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="gap:10px" class="d-flex align-items-end">
                                <a type="button" class="btn btn-primary"
                                    href="{{ route('target-iku-unit-kerja.create') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>
                        <div class="">
                            <table id="target-iku-unit-kerja"
                                class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 15px;">No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Unit Kerja</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($targetIkuUnitKerja as $ti)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $ti->nama_kegiatan }}</td>
                                        <td>{{ $unitKerja[$ti->unit_kerja] }}</td>
                                        <td>
                                            <span class="badge badge-{{ $colorBadge[$ti->status] }}">
                                                {{ $status[$ti->status] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('target-iku-unit-kerja.show', $ti->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($ti->status == 1)

                                            {{-- kirim ke realisasi --}}
                                            <form action="{{ route('target-iku-unit-kerja.status', $ti->id) }}"
                                                method="post" class="d-inline">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="status" value="2">
                                                <button class="btn btn-success btn-sm" type="submit">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('target-iku-unit-kerja.destroy', $ti->id) }}"
                                                method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" type="submit">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif

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

<!-- Page Specific JS File -->
{{-- <script src="{{ asset('js') }}/page/pegawai-pengelolaan-dokumen.js"></script> --}}

<script>
    let table = $("#target-iku-unit-kerja")
    .dataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    // filter: false,
    buttons: [
    {
    extend: "excel",
    className: "btn-success",
    text: '<i class="fas fa-file-excel"></i> Excel',
    filename: "Master Unsur",
    },
    {
    extend: "pdf",
    className: "btn-danger",
    text: '<i class="fas fa-file-pdf"></i> PDF',
    filename: "Master Unsur",
    },
    ],
    oLanguage: {
    sSearch: "Cari:",
    sZeroRecords: "Data tidak ditemukan",
    sEmptyTable: "Data tidak ditemukan",
    sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
    sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
    sInfoFiltered: "(disaring dari _MAX_ data)",
    sLengthMenu: "Tampilkan _MENU_ data",
    oPaginate: {
    sPrevious: "Sebelumnya",
    sNext: "Selanjutnya",
    },
    },
    })
    .api();
    $(".dt-buttons").appendTo("#download-button");
    $(".dt-buttons").appendTo("#download-button");
    $(".dataTables_filter").appendTo("#filter-search-wrapper");
    $(".dataTables_filter").find("input").addClass("form-control");
    // .dataTables_filter width 100%
    $(".dataTables_filter").css("width", "100%");
    // .dataTables_filter label width 100%
    $(".dataTables_filter label").css("width", "100%");
    // input height 35px
    $(".dataTables_filter input").css("height", "35px");
    // make label text bold and black
    $(".dataTables_filter label").css("font-weight", "bold");
    // remove bottom margin from .dataTables_filter
    $(".dataTables_filter label").css("margin-bottom", "0");

    $(".dataTables_filter input").attr(
    "placeholder",
    "Cari target iku unit kerja..."
    );
    // add padding x 10px to .dataTables_filter input
    $(".dataTables_filter input").css("padding", "0 10px");
    $(".dt-buttons").appendTo("#download-button");

    $("#target-iku-unit-kerja").on("search.dt", function () {
    table
    .column(0, { search: "applied", order: "applied" })
    .nodes()
    .each(function (cell, i) {
    cell.innerHTML = i + 1;
    });
    });

    function filterTable() {
    let filterUnitKerja = $("#filter-unit-kerja").val();
    let filterStatus = $("#filter-status").val();

    if (filterStatus == "Semua") {
    filterStatus = "";
    }
    if (filterUnitKerja == "Semua") {
    filterUnitKerja = "";
    }

    table
    .column(2)
    .search(filterUnitKerja, true, false)
    .column(3)
    .search(filterStatus, true, false)
    .draw();

    // reset numbering in table first column
    table
    .column(0, { search: "applied", order: "applied" })
    .nodes()
    .each(function (cell, i) {
    cell.innerHTML = i + 1;
    });
    }
    $("#filter-status, #filter-unit-kerja").on("change", function () {
    filterTable();
    });
</script>
@endpush
