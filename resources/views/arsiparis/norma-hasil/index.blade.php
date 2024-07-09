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
                            <div class="form-group mb-2">
                                <label for="yearSelect">Tahun Pengajuan</label>
                                <select name="year" id="yearSelect" class="form-control select2 col-md-1">
                                    @php
                                    $currentYear = date('Y');
                                    $lastThreeYears = range($currentYear, $currentYear - 3);
                                    @endphp
                
                                    @foreach ($lastThreeYears as $year)
                                    <option value="{{ $year }}" {{ request()->query('year') == $year ? 'selected' : '' }}>{{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display responsive"
                                    id="table-pengelolaan-dokumen-pegawai">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px; text-align:center">No</th>
                                            <th>Tugas</th>
                                            <th>Nomor Dokumen</th>
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
                                            <td></td>
                                            <td>{{ $lnm->rencanaKerja->tugas }}</td>
                                            <td>
                                                @if ($lnm->jenis == 1)
                                                    <span class="badge badge-primary">
                                                        R-{{ $lnm->normaHasilAccepted->nomor_norma_hasil}}/{{ $lnm->normaHasilAccepted->unit_kerja}}/{{ $lnm->normaHasilAccepted->kode_klasifikasi_arsip}}/{{ $lnm->normaHasilAccepted->normaHasil->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($lnm->normaHasilAccepted->tanggal_norma_hasil)) }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-primary">
                                                        Dokumen
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $lnm->normaHasilAccepted->normaHasil->laporanPengawasan->objekPengawasan->nama ??
                                                    $lnm->normaHasilDokumen->laporanPengawasan->objekPengawasan->nama }}</td>
                                            <td>{{ $months[$lnm->normaHasilAccepted->normaHasil->laporanPengawasan->month ?? $lnm->normaHasilDokumen->laporanPengawasan->month] }}</td>
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
                                                        {{ $status == 'ditolak' ? 'fa-solid fa-triangle-exclamation' : '' }}
                                                    "></i>{{ $status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/arsiparis/norma-hasil/{{ $lnm->id }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye
                                                    "></i>
                                                    Detail
                                                </a>
                                            </td>
                                            <td>{{ substr($lnm->tanggal_norma_hasil, 0, 4) }}</td>
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
{{-- <script>
        $(document).ready(function() {
            $('#table-pengelolaan-dokumen-pegawai').DataTable( {
            "columnDefs": [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
            });
        });
    </script> --}}

<!-- Page Specific JS File -->
<script>
    let table = $("#table-pengelolaan-dokumen-pegawai")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [],
            columnDefs: [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }]
        }).api();

    $('#yearSelect').on("change", function () {
        table.draw();
    });
    
    $.fn.dataTableExt.afnFiltering.push(
        function (setting, data, index) {
            var selectedYear = $('select#yearSelect option:selected').val();
            if (data[5] == selectedYear) return true;
            else return false;
        }
    );
</script>
@endpush
