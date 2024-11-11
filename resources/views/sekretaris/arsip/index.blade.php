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
                        <div class="d-flex justify-content-between">
                            <p class="mb-4">
                                <span class="badge alert-primary mr-2"><i class="fas fa-info"></i></span>
                                Menampilkan arsip surat srikandi yang telah diusulkan.
                            </p>
                            <div id="download-button">
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between flex-wrap my-2 mb-4" style="gap:10px">
                                <div class="form-group flex-grow-1" style="margin-bottom: 0;">
                                    <div id="filter-search-wrapper">
                                    </div>
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
                                    <label for="filter-month" style="margin-bottom: 0;">Jenis Surat</label>
                                    <select name="filter-surat" id="filter-surat" class="form-control select2">
                                        <option value="Semua">Semua</option>
                                        @foreach ( $jenisNaskahDinasPenugasan as $key => $jenis)
                                        <option value="{{ $jenis }}">
                                            {{ $jenis }}
                                        </option>
                                        @endforeach
                                        @foreach ( $jenisNaskahDinasKorespondensi as $key => $jenis)
                                        <option value="{{ $jenis }}">
                                            {{ $jenis }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- filter kode klasifikasi arsip --}}
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label for="filter-kka" style="margin-bottom: 0;">Kode Klasifikasi Arsip</label>
                                    <select name="filter-kka" id="filter-kka" class="form-control select2">
                                        <option disabled value="">Pilih Kode Klasifikasi Arsip</option>
                                        <option value="Semua">Semua</option>
                                        @foreach ($kodeKlasifikasiArsip as $kodeKlasifikasiArsip)
                                        <option
                                            {{ old('kodeKlasifikasiArsip') == $kodeKlasifikasiArsip->id ? 'selected' : '' }}
                                            value="{{ $kodeKlasifikasiArsip->kode }}">
                                            {{ $kodeKlasifikasiArsip->kode }} {{ $kodeKlasifikasiArsip->uraian }}
                                        </option>
                                        @endforeach
                                    </select>
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
                                            <option value="{{ $value->year }}"
                                                {{ $selectedYear == $value->year ? 'selected' : '' }}>
                                                {{ $value->year }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="">
                            <table id="table-usulan-surat-srikandi"
                                class="table table-bordered table-striped display responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">No</th>
                                        <th>Nomor Surat</th>
                                        <th>Nama Pengaju</th>
                                        <th>Tanggal</th>
                                        <th>Unit Kerja</th>
                                        <th style="width: 10px;">Kode Klasifikasi Arsip</th>
                                        <th>Jenis Surat</th>
                                        <th style="width: 50px;">Aksi</th>
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

                                                {{  $usulan->usulanSuratSrikandi->user->name }}
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($usulan->tanggal_persetujuan_srikandi)->format('d F Y') }}
                                        </td>
                                        <td>{{ $usulan->kepala_unit_penandatangan_srikandi }}</td>
                                        <td>{{ $usulan->kodeKlasifikasiArsip->kode ?? '' }}</td>
                                        <td>{{ $usulan->usulanSuratSrikandi->jenis_naskah_dinas_penugasan ? $jenisNaskahDinasPenugasan[$usulan->usulanSuratSrikandi->jenis_naskah_dinas_penugasan] : $jenisNaskahDinasKorespondensi[$usulan->usulanSuratSrikandi->jenis_naskah_dinas_korespondensi] }}
                                        <td>
                                            <a href="{{ route('sekretaris.surat-srikandi.show', $usulan->id_usulan_surat_srikandi) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sekretaris.surat-srikandi.download', $usulan->id_usulan_surat_srikandi) }}"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Download Surat Srikandi">
                                                <i class="fas fa-file-pdf"></i>
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
    $(function () {
    let table = $("#table-usulan-surat-srikandi")
    .dataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    pageLength: 25,
    buttons: [
    {
    extend: "excel",
    className: "btn-success",
    text: '<i class="fas fa-file-excel"></i> Excel',
    exportOptions: {
    columns: [0, 1, 2, 3, 4],
    },
    },
    {
    extend: "pdf",
    className: "btn-danger",
    text: '<i class="fas fa-file-pdf"></i> PDF',
    exportOptions: {
    columns: [0, 1, 2, 3, 4],
    },
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
    "Cari Arsip..."
    );
    // add padding x 10px to .dataTables_filter input
    $(".dataTables_filter input").css("padding", "0 10px");
    $(".dt-buttons").appendTo("#download-button");

    function filterTable() {
    let filterUnitKerja = $("#filter-unit_kerja").val();
    let filterSurat = $("#filter-surat").val();
    let filterKka = $("#filter-kka").val();

    if (filterSurat === "Semua") {
    filterSurat = "";
    }
    if (filterKka === "Semua") {
    filterKka = "";
    }


    if (filterUnitKerja === "Semua") {
    filterUnitKerja = "";
    }


    table
    .column(4)
    .search(filterUnitKerja, true, false)
    .column(6)
    .search(filterSurat, true, false)
    .column(5)
    .search(filterKka, true, false)
    .draw();


    // reset numbering in table first column
    table
    .column(0, { search: "applied", order: "applied" })
    .nodes()
    .each(function (cell, i) {
    cell.innerHTML = i + 1;
    });
    }

    $("#filter-unit_kerja, #filter-surat, #filter-kka"
    ).on("change", function () {
    filterTable();
    });

    $("#yearSelect").on("change", function () {
    let year = $(this).val();
    $("#yearForm").attr("action", `?year=${year}`);
    $("#yearForm").find('[name="_token"]').remove();
    $("#yearForm").trigger("submit");
    });
});
</script>
@endpush