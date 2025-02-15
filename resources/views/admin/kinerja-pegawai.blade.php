@extends('layouts.app')

@section('title', 'Monitoring Kinerja Pegawai')

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
                <h1>Monitoring Kinerja Pegawai</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                    <div class="breadcrumb-item">Kinerja Pegawai</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="yearForm" action="" method="GET" class="px-0">
                                    @csrf
                                    <div class="form-group">
                                        <label for="yearSelect">Pilih Tahun</label>
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
                                </form>
                                <table class="table table-bordered display responsive" id="table-inspektur-kinerja" style="background-color: #f6f7f8">
                                    <thead>
                                        <tr>
                                            <th>Tim</th>
                                            <th>PJK</th>
                                            <th>Tugas</th>
                                            <th>Nama Pegawai</th>
                                            <th>Output Kinerja Individu</th>
                                            <th>Objek Pengawasan</th>
                                            <th>Target Bulan Kinerja</th>
                                            <th>Status Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        @endphp
                                        @foreach ($pelaksana_tugas as $pelaksana)
                                            @if (count($pelaksana->rencanaKerja->objekPengawasan) > 0)
                                                @foreach ($pelaksana->rencanaKerja->objekPengawasan as $oPengawasan)
                                                    @foreach ($oPengawasan->laporanObjekPengawasan->where('status', 1) as $laporanObjek)
                                                        <tr class="table-bordered">
                                                            <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->nama }}</td>
                                                            <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->ketua->name }}</td>
                                                            <td>{{ $pelaksana->rencanaKerja->tugas }}</td>
                                                            <td>{{ $pelaksana->user->name }}</td>
                                                            <td>{{ 
                                                                count($pelaksana->rencanaKerja->hasilKerja->masterKinerja) == 0 ? 'Belum diisi' : 
                                                                $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first()->hasil_kerja
                                                            }}</td>
                                                            <td>{{ $oPengawasan->nama }}</td>
                                                            <td>{{ $bulan[$laporanObjek->month - 1] }}</td>
                                                            <td>
                                                                @if(isset($realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                                                                ->where('id_laporan_objek', $laporanObjek->id)
                                                                                ->where('status', 1)->first()->hasil_kerja))
                                                                    <a href="{{ $realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                                                                ->where('id_laporan_objek', $laporanObjek->id)
                                                                                ->where('status', 1)->first()->hasil_kerja }}" target="_blank">
                                                                        <div class="badge badge-success">Sudah Masuk</div>
                                                                    </a>
                                                                @else <div class="badge badge-danger">Belum Masuk</div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <tr class="table-bordered">
                                                    <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->nama }}</td>
                                                    <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->ketua->name }}</td>
                                                    <td>{{ $pelaksana->rencanaKerja->tugas }}</td>
                                                    <td>{{ $pelaksana->user->name }}</td>
                                                    <td>{{ 
                                                        count($pelaksana->rencanaKerja->hasilKerja->masterKinerja) == 0 ? 'Belum diisi' : 
                                                        $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first()->hasil_kerja
                                                    }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><div class="badge badge-warning">Belum Masuk</div></td>
                                                </tr>
                                            @endif
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
            rowsGroup: [0, 1, 2, 3, 4, 5],
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                }
            ],
        });

        $('#yearSelect').on('change', function() {
            $('#yearForm').find('[name="_token"]').remove();
            $('#yearForm').submit();
        });
    </script>
@endpush
