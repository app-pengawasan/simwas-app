@extends('layouts.app')

@section('title', 'Realisasi Jam Kerja')

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
                <h1>Realisasi Jam Kerja</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                    <div class="breadcrumb-item">Realisasi Jam Kerja</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <form id="yearForm" action="" method="GET" class="col-4">
                                        @csrf
                                        <div class="form-group">
                                            <label for="yearSelect">Pilih Tahun</label>
                                            <select name="year" id="yearSelect" class="form-control select2">
                                                @php
                                                $currentYear = date('Y');
                                                $lastThreeYears = range($currentYear, $currentYear - 3);
                                                @endphp
                            
                                                @foreach ($lastThreeYears as $year)
                                                <option value="{{ $year }}" {{ request()->query('year') == $year ? 'selected' : '' }}>{{ $year }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="unit" id="unitYear">
                                        </div>
                                    </form>
                                    <form id="unitForm" action="" method="GET" class="col-4">
                                        @csrf
                                        <div class="form-group">
                                            <label for="unitSelect">Pilih Unit Kerja</label>
                                            <select name="unit" id="unitSelect" class="form-control select2">
                                                <option value="8000" {{ request()->query('unit') == '8000' ? 'selected' : '' }}>Inspektorat Utama</option>
                                                <option value="8010" {{ request()->query('unit') == '8010' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                                <option value="8100" {{ request()->query('unit') == '8100' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                                <option value="8200" {{ request()->query('unit') == '8200' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                                <option value="8300" {{ request()->query('unit') == '8300' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                            </select>
                                            <input type="hidden" name="year" id="yearUnit">
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <table class="table table-bordered table-striped display responsive" id="table-inspektur-kinerja">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Pegawai</th>
                                                <th>Jumlah Tim</th>
                                                <th>Jumlah Proyek</th>
                                                <th>Jumlah Tugas</th>
                                                <th>Jumlah Jam Kerja</th>
                                                <th>Jumlah Hari Kerja</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($countall as $key => $count)
                                            <tr>
                                                <td></td>
                                                <td>{{ $count[0]->name }}</td>
                                                <td>{{ isset($count[1]) ? $count[1]['jumlah_tim'] : 0 }}</td>
                                                <td>{{ isset($count[1]) ? $count[1]['jumlah_proyek'] : 0 }}</td>
                                                <td>{{ isset($count[1]) ? $count[1]['jumlah_tugas'] : 0 }}</td>
                                                <td>{{ isset($count[1]) ? $count[1]['jam_kerja'] : 0 }}</td>
                                                <td>{{ isset($count[1]) ? $count[1]['hari_kerja'] : 0 }}</td>
                                                <td>
                                                    <a class="btn btn-primary detail"
                                                        href="/admin/realisasi-jam-kerja/pool/{{ $key }}/{{ date('Y') }}"
                                                        style="width: 42px">
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
    {{-- <script src="{{ asset('js') }}/page/inspektur-st-kinerja.js"></script> --}}
    <script>
        var datatable = $('#table-inspektur-kinerja').DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            // scrollX: true,
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

        $('#yearSelect').on('change', function() {
            let year = $(this).val();
            let unit = $('#unitSelect').val();
            $('#unitYear').val(unit);
            $('#yearForm').find('[name="_token"]').remove();
            $('#yearForm').submit();
        });

        $('#unitSelect').on('change', function() {
            let unit = $(this).val();
            let year = $('#yearSelect').val();
            $('#yearUnit').val(year);
            $('#unitForm').find('[name="_token"]').remove();
            $('#unitForm').submit();
        });

        $(".detail").attr('href', function(_, el){
            return el.replace(/\/[^\/]*$/, '/' + $('#yearSelect').val());
        });

        $('#table-inspektur-kinerja').on('draw.dt', function() {
            $(".detail").attr('href', function(_, el){
                return el.replace(/\/[^\/]*$/, '/' + $('#yearSelect').val());
            });
        });
    </script>
@endpush
