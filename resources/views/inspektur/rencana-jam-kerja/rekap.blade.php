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
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekap Rencana Jam Kerja</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/inspektur/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Rekap Rencana Hari Kerja</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
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
                                    <table class="table table-bordered table-striped display responsive" id="table-inspektur-kinerja">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="align-middle">No.</th>
                                                <th rowspan="2" class="align-middle">Pegawai</th>
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
                                            @foreach ($jam_kerja as $key => $jam)
                                            <tr>
                                                <td></td>
                                                <td>{{ $jam[0]->name }}</td>
                                                <td>
                                                    <a class="btn btn-primary detail"
                                                        href="/inspektur/rencana-jam-kerja/pool/{{ $key }}/{{ date('Y') }}"
                                                        style="width: 42px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                @isset($jam[1])
                                                    <td class="convert" value="{{ $jam[1]->jan }}">{{ $jam[1]->jan }}</td>
                                                    <td class="convert" value="{{ $jam[1]->feb }}">{{ $jam[1]->feb }}</td>
                                                    <td class="convert" value="{{ $jam[1]->mar }}">{{ $jam[1]->mar }}</td>
                                                    <td class="convert" value="{{ $jam[1]->apr }}">{{ $jam[1]->apr }}</td>
                                                    <td class="convert" value="{{ $jam[1]->mei }}">{{ $jam[1]->mei }}</td>
                                                    <td class="convert" value="{{ $jam[1]->jun }}">{{ $jam[1]->jun }}</td>
                                                    <td class="convert" value="{{ $jam[1]->jul }}">{{ $jam[1]->jul }}</td>
                                                    <td class="convert" value="{{ $jam[1]->agu }}">{{ $jam[1]->agu }}</td>
                                                    <td class="convert" value="{{ $jam[1]->sep }}">{{ $jam[1]->sep }}</td>
                                                    <td class="convert" value="{{ $jam[1]->okt }}">{{ $jam[1]->okt }}</td>
                                                    <td class="convert" value="{{ $jam[1]->nov }}">{{ $jam[1]->nov }}</td>
                                                    <td class="convert" value="{{ $jam[1]->des }}">{{ $jam[1]->des }}</td>
                                                    <td class="convert" value="{{ $jam[1]->total }}">{{ $jam[1]->total }}</td>
                                                @else
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                @endisset
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
        var datatable = $('#table-inspektur-kinerja').dataTable({
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
                        return $('#title').text();
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
            }]
        }).api();

        //update ukuran tabel saat ukuran sidebar berubah
        $('.nav-link').on("click", function () {
            setTimeout( function () {
                datatable.columns.adjust();
            }, 500);
        });

        $('#table-inspektur-kinerja_wrapper .dt-buttons').removeClass('btn-group');
        $('.toggle').wrapAll('<div class="btn-group"></div>');
        $('.hari-kerja').on('click', function() {
            $(this).addClass('disabled');
            $(this).attr('disabled', true);
            $(".jam-kerja").removeClass('disabled');
            $(".jam-kerja").attr('disabled', false);
            $(".convert").each(function() {
                let cell = datatable.cell(this);
                if (cell.data() != '0') cell.data((Number(cell.data()) / 7.5).toFixed(2)).draw();
            });
            $('#title').text('Rencana Hari Kerja');
        })
        $('.jam-kerja').on('click', function() {
            $(this).addClass('disabled');
            $(this).attr('disabled', true);
            $(".hari-kerja").removeClass('disabled');
            $(".hari-kerja").attr('disabled', false);
            $(".convert").each(function() {
                let cell = datatable.cell(this);
                if (cell.data() != '0') cell.data($(this).attr('value')).draw();
            });
            $('#title').text('Rencana Jam Kerja');
        })

        $('#yearSelect').on('change', function() {
            let year = $(this).val();
            $('#yearForm').attr('action', `?year=${year}`);
            $('#yearForm').find('[name="_token"]').remove();
            $('#yearForm').submit();
        });

        $(".detail").attr('href', function(_, el){
            return el.replace(/\/[^\/]*$/, '/' + $('#yearSelect').val());
        });
    </script>
@endpush
