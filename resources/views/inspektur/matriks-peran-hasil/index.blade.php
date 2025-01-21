@extends('layouts.app')

@section('title', 'Matriks Peran Hasil')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library') }}/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
@endpush

@section('main')
@include('components.inspektur-header')
@include('components.inspektur-sidebar')

<div class="main-content">

    <section class="section">
        <div class="section-header">
            <h1>Matriks Peran Hasil</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/inspektur">Dashboard</a></div>
                <div class="breadcrumb-item">Matriks Peran Hasil</div>
            </div>
        </div>
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
                                        @if ($unit == '8000')
                                            <input type="hidden" name="unit" id="unitYear">
                                        @endif
                                    </div>
                                </form>
                            </div>
                            @if ($unit == '8000')
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
                        <div class="">
                            <table id="tim-kerja" class="table table-bordered display responsive" style="background-color: #f6f7f8">
                                <thead>
                                    <tr>
                                        <th>Tugas</th>
                                        <th>Hasil Kerja Tim</th>
                                        <th>Pelaksana</th>
                                        <th>Jam Pengawasan</th>
                                        <th class="never">Unit Kerja</th>
                                        <th class="never">Tim PJK</th>
                                        <th class="never">Proyek</th>
                                        <th class="never">Peran</th>
                                        <th class="never">Rencana Kinerja</th>
                                        <th class="never">Indikator Kinerja Individu</th>
                                        <th class="never">Kegiatan</th>
                                        <th class="never">Hasil Kerja Pegawai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaksanaTugas as $pelaksana)
                                        @php
                                            //ambil rk, iki, kegiatan, dan hasil kerja pegawai
                                            $tugas = $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first();    
                                        @endphp
                                        <tr class="table-bordered">
                                            <td>{{ $pelaksana->rencanaKerja->tugas }}</td>
                                            <td>{{ $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja }}</td>
                                            <td>{{ $pelaksana->user->name }}</td>
                                            <td>{{ $pelaksana->jam_pengawasan }}</td>
                                            <td>{{ $unitkerja[$pelaksana->rencanaKerja->proyek->timKerja->unitkerja] }}</td>
                                            <td>{{ $pelaksana->rencanaKerja->proyek->timKerja->nama }}</td>
                                            <td>{{ $pelaksana->rencanaKerja->proyek->nama_proyek }}</td>
                                            <td>{{ $jabatanPelaksana[$pelaksana->pt_jabatan] }}</td>
                                            <td>{{ $tugas->rencana_kinerja }}</td>
                                            <td>{{ $tugas->iki }}</td>
                                            <td>{{ $tugas->kegiatan }}</td>
                                            <td>{{ $tugas->hasil_kerja }}</td>
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
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
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
<script>
    let table = $("#tim-kerja")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                rowsGroup: [0, 1],
                buttons: [
                    {
                        extend: "excel",
                        className: "btn-success mb-2",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [4, 5, 6, 0, 1, 2, 7, 8, 9, 10, 11, 3],
                        },
                    }
                ],
                pageLength: 25,
            })
            .api();

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
