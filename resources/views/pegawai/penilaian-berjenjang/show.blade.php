@extends('layouts.app')

@section('title', 'Daftar Realisasi')

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
        {{-- Modal --}}
        <div class="modal fade" id="kalenderModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="kalenderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kalenderModalLabel">Kalender Aktivitas Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="legend">
                            <li><span class="badge jingga">Sedang Dikerjakan</span></li>
                            <li><span class="badge hijau">Selesai</span></li>
                            <li><span class="badge merah">Dibatalkan</span></li>
                            <li><span class="badge hitam">Tidak Selesai</span></li>
                        </ul>
                        <center><div id='calendar' style="width: 90%"></div></center>
                    </div>
                </div>
            </div>
        </div>
        @include('components.penilaian.create');
        @include('components.penilaian.edit');
        @php 
            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; 
            $strbulan = ($bulan == 'all') ? '' : $months[(int)$bulan - 1];
        @endphp
        <section class="section">
            <div class="section-header">
                <h1>Daftar Realisasi {{ $realisasiDinilai[0]->pelaksana->user->name }} {{ $strbulan }} {{ $tahun }}</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('components.flash')
                            {{ session()->forget(['alert-type', 'status']) }}
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="/pegawai/nilai-berjenjang">
                                        <i class="fas fa-chevron-circle-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="mt-5" style="margin-top: 6rem">
                                <table id="table-nilai"
                                    class="table table-bordered display responsive" style="background-color: #f6f7f8">
                                    <thead>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>Objek Pengawasan</th>
                                            <th>Bulan Pelaporan</th>
                                            <th>Peran</th>
                                            <th>Rencana Jam Kerja</th>
                                            <th>Realisasi Jam Kerja</th>
                                            <th>Bukti Dukung</th>
                                            <th>Catatan Pegawai</th>
                                            <th>Nilai</th>
                                            <th>Catatan Penilai</th>
                                            <th>Aksi</th>
                                            <th class="d-none">Link Bukti Dukung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des']; 
                                            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                                                        'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        @endphp
                                        @foreach ($realisasiDinilai as $realisasi)
                                            @php 
                                                $rencana_jam = 0; 
                                                foreach ($bulans as $bulan) {
                                                    $rencana_jam += $realisasi->pelaksana[$bulan];
                                                }
                                            @endphp
                                            <tr style="border: 1px solid #dee2e6;">
                                                <td>{{ $realisasi->pelaksana->rencanaKerja->tugas }}</td>
                                                <td>{{ $realisasi->laporanObjekPengawasan->objekPengawasan->nama }}</td>
                                                <td>{{ $months[$realisasi->laporanObjekPengawasan->month - 1] }}</td>
                                                <td>{{ $jabatan[$realisasi->pelaksana->pt_jabatan] }}</td>
                                                <td>{{ $rencana_jam }}</td>
                                                <td>{{ $jamRealisasi[$realisasi->id_laporan_objek] }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                    href="{{ $realisasi->hasil_kerja }}" target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a> 
                                                </td>
                                                <td>{{ $realisasi->catatan }}</td>
                                                <td>{{ $realisasi->nilai }}</td>
                                                <td>{{ $realisasi->catatan_penilai }}</td>
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle no-arrow" 
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">...
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right shadow-lg">
                                                            <a href="/pegawai/nilai-berjenjang/detail/{{ $realisasi->id }}" 
                                                            class="dropdown-item">
                                                                <i class="fas fa-circle-info text-primary mr-2"></i>
                                                                Detail
                                                            </a>
                                                            @if ($realisasi->nilai == '')
                                                                <a class="dropdown-item nilai-btn" href="javascript:void(0)"
                                                                data-id="{{ $realisasi->id }}" data-toggle="modal" 
                                                                data-target="#modal-create-nilai">
                                                                    <i class="fas fa-circle-plus text-success mr-2"></i>
                                                                    Nilai
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item edit-btn" href="javascript:void(0)"
                                                                data-id="{{ $realisasi->id }}" data-toggle="modal" 
                                                                data-target="#modal-edit-nilai">
                                                                    <i class="fas fa-edit text-warning mr-2"></i>
                                                                    Edit Nilai
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="d-none">{{ $realisasi->hasil_kerja }}</td>
                                            </tr>
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
    <script src="{{ asset('library') }}/fullcalendar-6.1.10/dist/index.global.min.js"></script>
    <script src="{{ asset('library') }}/moment/min/moment-with-locales.min.js"></script>
    <script src="{{ asset('js') }}/plugins/datatables-rowsgroup/dataTables.rowsGroup.js"></script>

    <!-- Page Specific JS File -->
    <script>
        var events = @json($events);
        var pegawai = @json($realisasiDinilai[0]->pelaksana->id_pegawai);
    </script>
    <script src="{{ asset('js/page/pegawai/penilaian-berjenjang.js') }}"></script>
@endpush
