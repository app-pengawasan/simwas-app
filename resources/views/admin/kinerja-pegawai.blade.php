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
                                <div class="d-flex mb-2 row" style="gap:10px">
                                    <div class="form-group col" style="margin-bottom: 0;">
                                        <form id="yearForm" action="" method="GET">
                                            @csrf
                                            <div class="form-group">
                                                <label for="filter-tahun" style="margin-bottom: 0;">
                                                    Tahun</label>
                                                @php
                                                $currentYear = date('Y');
                                                $selectedYear = request()->query('year', $currentYear);
                                                @endphp
                
                                                <select name="year" id="yearSelect" class="form-control select2">
                                                    @foreach ($year as $key => $value)
                                                    <option value="{{ $value->tahun }}" {{ $selectedYear == $value->tahun ? 'selected' : '' }}>
                                                        {{ $value->tahun }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($unit == '8000' || $unit == '8010')
                                                    <input type="hidden" name="unit" id="unitYear">
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                    @if ($unit == '8000' || $unit == '8010')
                                        <div class="form-group col pl-0" style="margin-bottom: 0;">
                                            <form id="unitForm" action="" method="GET">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="unitSelect" class="mb-0">Pilih Unit Kerja</label>
                                                    <select name="unit" id="unitSelect" class="form-control select2">
                                                        <option value="8000" {{ request()->query('unit') == '8000' ? 'selected' : '' }}>Semua</option>
                                                        <option value="8010" {{ request()->query('unit') == '8010' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                                        <option value="8100" {{ request()->query('unit') == '8100' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                                        <option value="8200" {{ request()->query('unit') == '8200' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                                        <option value="8300" {{ request()->query('unit') == '8300' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                                    </select>
                                                    <input type="hidden" name="year" id="yearUnit">
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
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
                                            <th class="never">Realisasi Bulan</th>
                                            <th class="never">Status</th>
                                            <th class="never">Rencana Jam Kerja</th>
                                            <th class="never">Realisasi Jam Kerja</th>
                                            <th class="never">Hasil Kerja Tim</th>
                                            <th class="never">Sub Unsur</th>
                                            <th class="never">Unsur</th>
                                            <th class="never">IKU</th>
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
                                                                @if ($realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                                                                ->where('id_laporan_objek', $laporanObjek->id)->first() != null)
                                                                    @php 
                                                                        $dokumen = $realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                                                                             ->where('id_laporan_objek', $laporanObjek->id)->first();
                                                                    @endphp
                                                                    @if ($dokumen->status == 1)
                                                                        <a href="{{ $dokumen->hasil_kerja }}" target="_blank">
                                                                            <div class="badge badge-success">Sudah Masuk</div>
                                                                        </a>
                                                                    @elseif ($dokumen->status == 2) <div class="badge badge-danger">Dibatalkan</div>
                                                                    @else <div class="badge badge-dark">Tidak Selesai</div>
                                                                    @endif
                                                                @else 
                                                                    @php unset($dokumen) @endphp
                                                                    <div class="badge badge-warning">Belum Masuk</div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (isset($dokumen) && $dokumen->status == 1)
                                                                    {{ $bulan[date("n",strtotime($dokumen->tgl_upload)) - 1] }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (isset($dokumen) && $dokumen->status == 1)
                                                                    @php
                                                                        $targetthn = request()->query('year') ?? date('Y');
                                                                        $targetbln = $targetthn.'-'.sprintf('%02d', $laporanObjek->month).'-01';
                                                                        $realisasibln = date("Y-m",strtotime($dokumen->tgl_upload)).'-01';
                                                                    @endphp
                                                                    @if ($realisasibln < $targetbln) Lebih Cepat
                                                                    @elseif ($realisasibln == $targetbln) Tepat Waktu
                                                                    @else Terlambat
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>{{ $pelaksana->jam_pengawasan }}</td>
                                                            <td>
                                                                @php 
                                                                    $total_jam = 0; 
                                                                    foreach ($events->where('laporan_opengawasan', $laporanObjek->id)
                                                                                    ->where('id_pegawai', $pelaksana->id_pegawai) as $event) {
                                                                        $start = $event->start;
                                                                        $end = $event->end;
                                                                        $total_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                                                                    }
                                                                @endphp
                                                                {{ $total_jam }}
                                                            </td>
                                                            <td>{{ $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja }}</td>
                                                            <td>{{ $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur }}</td>
                                                            <td>{{ $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur }}</td>
                                                            <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->iku->iku }}</td>
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
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ $pelaksana->jam_pengawasan }}</td>
                                                    <td>0</td>
                                                    <td>{{ $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja }}</td>
                                                    <td>{{ $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur }}</td>
                                                    <td>{{ $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur }}</td>
                                                    <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->iku->iku }}</td>
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
            rowsGroup: [0, 1, 2, 3, 4, 5],
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                }
            ],
        });

        $('#yearSelect').on('change', function() {
            let year = $(this).val();
            let unit = $('#unitSelect').val();
            $('#unitYear').val(unit);
            $('#yearForm').attr('action', `?year=${year}&unit=${unit}`);
            $('#yearForm').find('[name="_token"]').remove();
            $('#yearForm').submit();
        });

        $('#unitSelect').on('change', function() {
            let unit = $(this).val();
            let year = $('#yearSelect').val();
            $('#yearUnit').val(year);
            $('#unitForm').attr('action', `?unit=${unit}&year=${year}`);
            $('#unitForm').find('[name="_token"]').remove();
            $('#unitForm').submit();
        });
    </script>
@endpush
