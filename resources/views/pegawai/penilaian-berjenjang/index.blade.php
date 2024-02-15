@extends('layouts.app')

@section('title', 'Nilai Hasil Kerja Bulanan')

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
        <section class="section">
            <div class="section-header">
                <h1>Nilai Hasil Kerja Bulanan</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex float-right col-6">
                                <div class="ml-auto my-2 col-12 p-0 pl-2">
                                    <select class="form-control" id="filterBulan">
                                        <option value="all">Semua Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex float-right col-6 p-0">
                                <div class="ml-auto my-2 col-12 p-0 pr-2">
                                    <select class="form-control" id="filterUnitKerja" autocomplete="off">
                                        <option value="all">Semua Unit Kerja</option>
                                        <option value="8000">Inspektorat Utama</option>
                                        <option value="8010">Bagian Umum Inspektorat Utama</option>
                                        <option value="8100">Inspektorat Wilayah I</option>
                                        <option value="8200">Inspektorat Wilayah II</option>
                                        <option value="8300">Inspektorat Wilayah III</option>
                                    </select>
                                </div>
                            </div>
                            <div style="margin-top: 5rem">
                                <table id="table-daftar-nilai"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Unit Kerja</th>
                                            <th>Jumlah Tugas</th>
                                            <th>Rencana Jam Kerja</th>
                                            <th>Realisasi Jam Kerja</th>
                                            <th>Rata-Rata Hasil Penilaian</th>
                                            <th>Aksi</th>
                                            <th class="never">Bulan</th>
                                            <th class="never">Unit Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugasCount as $id_pegawai => $bulan)
                                            @foreach ($bulan as $key => $count)
                                                <tr>
                                                    <td>{{ $count['nama'] }}</td>
                                                    <td>{{ $unitkerja[$count['unit_kerja']] }}</td>
                                                    <td>{{ $count['count'] }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ $count['avg'] }}</td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                            href="/pegawai/nilai-berjenjang/{{ $id_pegawai }}/{{ $key }}"
                                                            style="width: 42px">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $count['unit_kerja'] }}</td>
                                                </tr>
                                            @endforeach
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
    <script src="{{ asset('js/page/pegawai/penilaian-berjenjang.js') }}"></script>
@endpush
