@extends('layouts.app')

@section('title', 'Kinerja Tim')

@push('style')
    <!-- CSS Libraries -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kinerja Tim {{ str_ireplace('tim ', '', $laporanObjek->first()->objekPengawasan->rencanakerja->proyek->timkerja->nama) }} Bulan {{ $months[$bulan] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                    <div class="breadcrumb-item">Kinerja Tim</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div class="col-md-4 mb-4 pl-0">
                                        <a class="btn btn-primary" href="/admin/kinerja-tim">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>
                                    </div>
                                    <table class="table table-bordered display responsive" id="table-inspektur-kinerja">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px; text-align:center" rowspan="2">No</th>
                                                <th style="text-align:center" rowspan="2">Tugas</th>
                                                <th style="text-align:center" rowspan="2">Objek Pengawasan</th>
                                                <th style="text-align:center" colspan="2">Surat Tugas</th>
                                                <th style="text-align:center" colspan="2">Norma Hasil</th>
                                                <th style="text-align:center" rowspan="2">Kendali Mutu</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align:center">Nomor Surat Tugas</th>
                                                <th style="text-align:center">File</th>
                                                <th style="text-align:center">Nomor Laporan</th>
                                                <th style="text-align:center">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporanObjek as $bulan)
                                                <tr class="table-bordered">
                                                    <td></td>
                                                    <td>{{ $bulan->objekPengawasan->rencanaKerja->tugas }}</td>
                                                    <td>{{ $bulan->objekPengawasan->nama }}</td>
                                                    @if (isset($surat_tugas[$bulan->objekPengawasan->id_rencanakerja]))
                                                        <td>
                                                            <span class="badge badge-primary">
                                                                {{ $surat_tugas[$bulan->objekPengawasan->id_rencanakerja]->nomor_surat }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a class="badge badge-primary p-2" target="_blank"
                                                                href="/{{ $surat_tugas[$bulan->objekPengawasan->id_rencanakerja]->suratSrikandi[0]->document_srikandi_pdf_path }}">
                                                                <i class="fa-solid fa-eye mr-1"></i>Lihat</a>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                    @endif
                                                    @if (isset($norma_hasil[$bulan->id]))
                                                        @if ($norma_hasil[$bulan->id]->jenis == 1)
                                                            <td>
                                                                <span class="badge badge-primary">
                                                                    R-{{ $norma_hasil[$bulan->id]->nomor_norma_hasil}}/{{ $norma_hasil[$bulan->id]->unit_kerja}}/{{ $norma_hasil[$bulan->id]->kode_klasifikasi_arsip}}/{{ $norma_hasil[$bulan->id]->normaHasil->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($norma_hasil[$bulan->id]->tanggal_norma_hasil)) }}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span class="badge badge-primary">
                                                                    Dokumen
                                                                </span>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td></td>
                                                    @endif

                                                    @if (isset($norma_hasil[$bulan->id]->laporan_path))
                                                        <td>
                                                            @if ($norma_hasil[$bulan->id]->jenis == 1)
                                                                <a target="blank" href="/pegawai/tim/norma-hasil/viewLaporan/{{ $norma_hasil[$bulan->id]->id }}/1"
                                                                    class="badge btn-primary"><i
                                                                        class="fa fa-eye mr-1"></i> Lihat</a>
                                                            @else
                                                                <a target="blank" href="/pegawai/tim/norma-hasil/viewLaporan/{{ $norma_hasil[$bulan->id]->id }}/2"
                                                                    class="badge btn-primary"><i
                                                                        class="fa fa-eye mr-1"></i> Lihat</a>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif

                                                    @if (isset($kendali_mutu[$bulan->id]->path))
                                                        <td>
                                                            @if (file_exists($kendali_mutu[$bulan->id]->path))
                                                                <a target="blank" href="/pegawai/tim/kendali-mutu/download/{{ $kendali_mutu[$bulan->id]->id }}"
                                                                    class="badge btn-primary"><i
                                                                        class="fa fa-eye mr-1"></i> Lihat</a>
                                                            @else
                                                                <a target="blank" href="{{ $kendali_mutu[$bulan->id]->path }}"
                                                                    class="badge btn-primary"><i
                                                                        class="fa fa-eye mr-1"></i> Lihat</a>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
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
    <script src="{{ asset('js') }}/plugins/datatables-rowsgroup/dataTables.rowsGroup.js"></script>
    
    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js') }}/page/inspektur-st-kinerja.js"></script> --}}
    <script>
        var datatable = $('#table-inspektur-kinerja').DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            // scrollX: true,
            rowsGroup: [1, 3, 4, 2],
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6],
                    },
                }
            ],
            columnDefs: [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }],
        });
    </script>
@endpush
