@extends('layouts.app')

@section('title', 'Rencana Jam Kerja')

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
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rencana Jam Kerja</h1>
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
                                <div class="mt-3">
                                    <table class="table table-bordered table-striped display responsive" id="table-pegawai-kinerja">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle">No.</th>
                                                <th rowspan="2" class="align-middle">Tim</th>
                                                <th rowspan="2" class="align-middle">Proyek</th>
                                                <th rowspan="2" class="align-middle">Tugas</th>
                                                <th rowspan="2" class="align-middle">Peran</th>
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
                                            @foreach ($tugas as $t)
                                            @php $total += $t->total @endphp
                                            <tr>
                                                <td></td>
                                                <td>{{ $t->rencanaKerja->proyek->timkerja->nama }}</td>
                                                <td>{{ $t->rencanaKerja->proyek->nama_proyek }}</td>
                                                <td>{{ $t->rencanaKerja->tugas }}</td>
                                                <td>{{ $jabatan[$t->pt_jabatan] }}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                        href="/pegawai/rencana-kinerja/{{ $t->rencanaKerja->id_rencanakerja }}"
                                                        style="width: 42px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td class="convert" value={{ $t->jan }}>{{ $t->jan }}</td>
                                                <td class="convert" value={{ $t->feb }}>{{ $t->feb }}</td>
                                                <td class="convert" value={{ $t->mar }}>{{ $t->mar }}</td>
                                                <td class="convert" value={{ $t->apr }}>{{ $t->apr }}</td>
                                                <td class="convert" value={{ $t->mei }}>{{ $t->mei }}</td>
                                                <td class="convert" value={{ $t->jun }}>{{ $t->jun }}</td>
                                                <td class="convert" value={{ $t->jul }}>{{ $t->jul }}</td>
                                                <td class="convert" value={{ $t->agu }}>{{ $t->agu }}</td>
                                                <td class="convert" value={{ $t->sep }}>{{ $t->sep }}</td>
                                                <td class="convert" value={{ $t->okt }}>{{ $t->okt }}</td>
                                                <td class="convert" value={{ $t->nov }}>{{ $t->nov }}</td>
                                                <td class="convert" value={{ $t->des }}>{{ $t->des }}</td>
                                                <td class="convert" value={{ $t->total }}>{{ $t->total }}</td>
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
        var datatable = $('#table-pegawai-kinerja').DataTable({
            dom: "Bfrtip",
            responsive: false,
            lengthChange: false,
            autoWidth: false,
            scrollX: true,
            pageLength: 25,
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
        $('#table-pegawai-kinerja_wrapper .dt-buttons').removeClass('btn-group');
        $('.toggle').wrapAll('<div class="btn-group"></div>');
        $('.hari-kerja').on('click', function() {
            $(this).addClass('disabled');
            $(this).attr('disabled', true);
            $(".jam-kerja").removeClass('disabled');
            $(".jam-kerja").attr('disabled', false);
            $(".convert, .dataTables_scrollFoot .total").each(function() {
                $(this).text( (Number($(this).text()) / 7.5).toFixed(2) );
            });
            $('#title').text('Rencana Hari Kerja');
        });

        $('.jam-kerja').on('click', function() {
            $(this).addClass('disabled');
            $(this).attr('disabled', true);
            $(".hari-kerja").removeClass('disabled');
            $(".hari-kerja").attr('disabled', false);
            $(".convert, .dataTables_scrollFoot .total").each(function() {
                $(this).text($(this).attr('value'));
            });
            $('#title').text('Rencana Jam Kerja');
        });

        $('#yearSelect').on('change', function() {
            let year = $(this).val();
            $('#yearForm').attr('action', `?year=${year}`);
            $('#yearForm').find('[name="_token"]').remove();
            $('#yearForm').submit();
        });
    </script>
@endpush
