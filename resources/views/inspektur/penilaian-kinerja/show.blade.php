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
    @include('components.inspektur-header')
    @include('components.inspektur-sidebar')
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
                            {{-- <li><span class="jingga"></span> Sedang Dikerjakan</li>
                            <li><span class="hijau"></span> Selesai</li>
                            <li><span class="merah"></span> Dibatalkan</li> --}}
                            <li><span class="badge jingga">Sedang Dikerjakan</span></li>
                            <li><span class="badge hijau">Selesai</span></li>
                            <li><span class="badge merah">Dibatalkan</span></li>
                        </ul>
                        <center><div id='calendar' style="width: 90%"></div></center>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Daftar Realisasi {{ $realisasiDinilai[0]->pelaksana->user->name }}</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="/inspektur/penilaian-kinerja">
                                        <i class="fas fa-chevron-circle-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="mt-5">
                                <table id="table-nilai"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>Peran</th>
                                            <th>Rencana Jam Kerja</th>
                                            <th>Realisasi Jam Kerja</th>
                                            <th>Bukti Dukung</th>
                                            <th>Catatan Pegawai</th>
                                            <th>Nilai</th>
                                            <th>Penilai</th>
                                            <th>Catatan Penilai</th>
                                            <th>Aksi</th>
                                            <th class="never">Link Bukti Dukung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $bulans = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des']; 
                                        @endphp
                                        @foreach ($realisasiDinilai as $realisasi)
                                            @php 
                                                $rencana_jam = 0; 
                                                foreach ($bulans as $bulan) {
                                                    $rencana_jam += $realisasi->pelaksana[$bulan];
                                                }
                                            @endphp
                                            <tr>
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
                                                <td>{{ $realisasi->catatan }}</td>
                                                <td>{{ $realisasi->nilai }}</td>
                                                <td>{{ $realisasi->getPenilai->name ?? '' }}</td>
                                                <td>{{ $realisasi->catatan_penilai }}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                        href="/inspektur/penilaian-kinerja/detail/{{ $realisasi->id }}"
                                                        style="width: 42px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if (file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja))
                                                        {{ url('/').'/document/realisasi/'.$realisasi->hasil_kerja }}
                                                    @else
                                                        {{ $realisasi->hasil_kerja }}
                                                    @endif
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

    <!-- Page Specific JS File -->
    <script>
        var events = @json($events);
    </script>
    <script src="{{ asset('js/page/inspektur-penilaian-kinerja.js') }}"></script>
@endpush
