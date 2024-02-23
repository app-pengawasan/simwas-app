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
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Realisasi Jam Kerja {{ $count->first()['pegawai'] }}</h1> 
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/inspektur/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Realisasi Jam Kerja</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4 pb-0">
                                    <div class="col-md-4">
                                        <a class="btn btn-primary" href="/inspektur/realisasi-jam-kerja/pool">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <table class="table table-bordered table-striped display responsive" id="table-inspektur-kinerja">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle">No.</th>
                                                <th rowspan="2" class="align-middle">Tim</th>
                                                <th rowspan="2" class="align-middle">Proyek</th>
                                                <th rowspan="2" class="align-middle">Tugas</th>
                                                <th rowspan="2" class="align-middle">Jabatan</th>
                                                <th rowspan="2" class="align-middle">Detail</th>
                                                <th colspan="13" class="text-center" id="title">Rencana Jam Kerja</th>
                                            </tr>
                                            <tr>
                                                <th>Jan</th>
                                                <th>Feb</th>
                                                <th>Mar</th>
                                                <th>Apr</th>
                                                <th>Mei</th>
                                                <th>Jun</th>
                                                <th>Jul</th>
                                                <th>Agu</th>
                                                <th>Sep</th>
                                                <th>Okt</th>
                                                <th>Nov</th>
                                                <th>Des</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total = 0; @endphp
                                            @foreach ($count as $key => $c)
                                            @php $total += $c['total'] @endphp
                                            <tr>
                                                <td></td>
                                                <td>{{ $c['tim'] }}</td>
                                                <td>{{ $c['proyek'] }}</td>
                                                <td>{{ $c['tugas'] }}</td>
                                                <td>{{ $jabatan[$c['jabatan']] }}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                        href="/inspektur/realisasi-jam-kerja/detail/{{ $key }}"
                                                        style="width: 42px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td class="convert">{{ $c['realisasi_jam']['01'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['02'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['03'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['04'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['05'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['06'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['07'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['08'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['09'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['10'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['11'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['realisasi_jam']['12'] ?? 0 }}</td>
                                                <td class="convert">{{ $c['total'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="font-weight-bold">
                                            <tr>
                                                <td colspan="18" class="text-center">Total</td>
                                                <td class="total" value="{{ $total }}">{{ $total }}</td>
                                            </tr>
                                        </tfoot>
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
        $(".convert").each(function() {
            $(this).attr('value', $(this).text());
        });

        var datatable = $('#table-inspektur-kinerja').DataTable({
            dom: "Bfrtip",
            responsive: false,
            lengthChange: false,
            autoWidth: false,
            scrollX: true,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    messageTop: function () {
                        return $('.section-header h1').text();
                    },
                },
                {
                    text: 'Jam Kerja',
                    className: 'btn btn-primary disabled ml-2 jam-kerja toggle',
                },
                {
                    text: 'Hari Kerja',
                    className: 'btn btn-primary hari-kerja toggle',
                }
            ],
            columnDefs: [{
                "targets": 0,
                "createdCell": function (td, cellData, rowData, row, col) {
                $(td).text(row + 1);
                }
            }],
        });
        $('#table-inspektur-kinerja_wrapper .dt-buttons').removeClass('btn-group');
        $('.toggle').wrapAll('<div class="btn-group"></div>');
        $('.hari-kerja').on('click', function() {
            $(this).addClass('disabled');
            $(this).attr('disabled', true);
            $(".jam-kerja").removeClass('disabled');
            $(".jam-kerja").attr('disabled', false);
            $(".convert, .dataTables_scrollFoot .total").each(function() {
                if ($(this).text() != '0') $(this).text( (Number($(this).text()) / 7.5).toFixed(2) );
            });
            $('#title').text('Realisasi Hari Kerja');
        })
        $('.jam-kerja').on('click', function() {
            $(this).addClass('disabled');
            $(this).attr('disabled', true);
            $(".hari-kerja").removeClass('disabled');
            $(".hari-kerja").attr('disabled', false);
            $(".convert, .dataTables_scrollFoot .total").each(function() {
                if ($(this).text() != '0') $(this).text($(this).attr('value'));
            });
            $('#title').text('Realisasi Jam Kerja');
        })
    </script>
@endpush
