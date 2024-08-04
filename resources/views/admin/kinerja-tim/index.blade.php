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
                <h1>Kinerja Tim</h1>
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
                                <table class="table table-bordered display responsive" id="table-inspektur-kinerja">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Tim</th>
                                            <th>PJK</th>
                                            <th>Bulan Pelaporan</th>
                                            <th>Jumlah Tugas</th>
                                            <th>Surat Tugas</th>
                                            <th>Target Norma Hasil</th>
                                            <th>Norma Hasil Masuk</th>
                                            <th>Kendali Mutu</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_tim as $id => $tim)
                                            @foreach ($tim['data_bulan'] as $bulan => $data)
                                                @if ($data['jumlah_tugas'] != '-')
                                                    <tr class="table-bordered">
                                                        <td></td>
                                                        <td>{{ $tim['nama'] }}</td>
                                                        <td>{{ $tim['pjk'] }}</td>
                                                        <td>{{ $months[$bulan] }}</td>
                                                        <td>{{ $data['jumlah_tugas'] }}</td>
                                                        <td>{{ $data['jumlah_st'] }}</td>
                                                        <td>{{ $data['target_nh'] }}</td>
                                                        <td>{{ $data['jumlah_nh'] }}</td>
                                                        <td>{{ $data['jumlah_km'] }}</td>
                                                        <td>
                                                            <a class="btn btn-primary btn-sm" id="detail"
                                                                href="/admin/kinerja-tim/{{ $id }}/{{ $bulan }}"
                                                                style="width: 42px">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
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
            rowsGroup: [1, 2],
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
            $('#yearForm').find('[name="_token"]').remove();
            $('#yearForm').submit();
        });

       
    </script>
@endpush
