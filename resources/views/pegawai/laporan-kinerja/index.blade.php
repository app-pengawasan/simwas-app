@extends('layouts.app')

@section('title', 'Laporan Kinerja')

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
                <h1>Laporan Kinerja</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex float-right col-6 p-0 pl-2">
                                <div class="ml-auto my-2 col-12 p-0">
                                    <select class="form-control" id="filterTahun">
                                        <?php $year = date('Y'); ?>
                                        @for ($i = -5; $i < 8; $i++)
                                            <option value="{{ $year + $i }}">{{ $year + $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex float-right col-6 p-0 pr-1 pl-1">
                                <div class="ml-auto my-2 col-12 p-0">
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
                            <div style="margin-top: 5rem">
                                <table id="table-nilai"
                                    class="table table-bordered display responsive" style="background-color: #f6f7f8">
                                    <thead>
                                        <tr>
                                            <th class="bulan">Bulan</th>
                                            <th>Tugas</th>
                                            <th>Peran</th>
                                            <th>Rencana Jam Kerja</th>
                                            <th>Realisasi Jam Kerja</th>
                                            <th>Bukti Dukung</th>
                                            <th>Penilaian Berjenjang</th>
                                            <th>Penilaian Pimpinan</th>
                                            <th class="never">bulan</th>
                                            <th class="never">tahun</th>
                                            <th class="never">Link Bukti Dukung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des']; 
                                            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        @endphp
                                        @foreach ($realisasiDone as $tahun => $items) 
                                            @foreach ($items as $month => $realisasiList)
                                                @foreach ($realisasiList as $key => $realisasi)
                                                    @php 
                                                        $rencana_jam = 0; 
                                                        foreach ($bulans as $bulan) {
                                                            $rencana_jam += $realisasi->pelaksana[$bulan];
                                                        }
                                                    @endphp
                                                    <tr class="table-bordered">
                                                        <td class="bulan">{{ $months[(int)$month - 1] }}</td>
                                                        <td>{{ $realisasi->pelaksana->rencanaKerja->tugas }}</td>
                                                        <td>{{ $jabatan[$realisasi->pelaksana->pt_jabatan] }}</td>
                                                        <td>{{ $rencana_jam }}</td>
                                                        <td>{{ $jamRealisasi[$realisasi->id_pelaksana] }}</td>
                                                        <td>
                                                            @if (file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja))
                                                                <a class="btn btn-primary"
                                                                href="{{ asset('document/realisasi/'.$realisasi->hasil_kerja) }}" target="_blank">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @else
                                                                <a class="btn btn-primary"
                                                                href="{{ $realisasi->hasil_kerja }}" target="_blank">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @endif    
                                                        </td>
                                                        <td>{{ $realisasi->nilai }}</td> 
                                                        <td>{{ $nilai_ins->where('bulan', $month)->where('tahun', $tahun)->first()->nilai ?? null }}</td>
                                                        <td>{{ $month }}</td>
                                                        <td>{{ $tahun }}</td>
                                                        <td>
                                                            @if (file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja))
                                                                {{ url('/').'/document/realisasi/'.$realisasi->hasil_kerja }}
                                                            @else
                                                                {{ $realisasi->hasil_kerja }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
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
    {{-- <script src="{{ asset('js/page/pegawai/penilaian-berjenjang.js') }}"></script> --}}
    <script>
        let today = new Date();
        $('#filterBulan').val(("0" + (today.getMonth() + 1)).slice(-2));
        $('#filterTahun').val(today.getFullYear());

        let table = $("#table-nilai")
            .dataTable({
                dom: "Bfrtip",
                // responsive: true,
                lengthChange: false,
                autoWidth: false,
                rowsGroup: [0, 7],
                buttons: [
                    {
                        extend: "excel",
                        className: "btn-success",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 10, 6, 7],
                        },
                        messageTop: function () {
                            return $(":selected", '#filterBulan').text() + ', ' 
                                   + $(":selected", '#filterTahun').text();
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 10, 6, 7],
                        },
                        messageTop: function () {
                            return $(":selected", '#filterBulan').text() + ', ' 
                                   + $(":selected", '#filterTahun').text();
                        },
                    }
                ],
            }).api();

            $('#filterBulan').on("change", function () {
                if ($(this).val() == 'all') $('.bulan').show();
                table.draw();
                if ($(this).val() != 'all') $('.bulan').hide();
            }); 
            
            $('#filterTahun').on("change", function () {
                table.draw();
            });

            
            $.fn.dataTableExt.afnFiltering.push(
                function (setting, data, index) {
                    var selectedBulan = $('select#filterBulan option:selected').val();
                    var selectedTahun = $('select#filterTahun option:selected').val();
                    // alert(data[7])
                    if ((data[8] == selectedBulan || selectedBulan == 'all') && data[9] == selectedTahun) return true;
                    else return false;
                }
                );
                
            table.draw();
            $('.bulan').hide();
    </script>
@endpush
