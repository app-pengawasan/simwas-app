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
        <!-- Modal -->
        @include('pegawai.penilaian-berjenjang.create');
        @include('pegawai.penilaian-berjenjang.edit');
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
                                    <a class="btn btn-primary" href="/pegawai/nilai-berjenjang">
                                        <i class="fas fa-chevron-circle-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <center><div id='calendar' style="width: 90%" class="mt-5"></div></center>
                            <div class="mt-5">
                                @include('components.flash')
                                {{ session()->forget(['alert-type', 'status']) }}
                                <table id="table-nilai"
                                    class="table table-bordered table-striped display responsive">
                                    <thead>
                                        <tr>
                                            <th>Tugas</th>
                                            <th>Rencana Jam Kerja</th>
                                            <th>Realisasi Jam Kerja</th>
                                            <th>Status</th>
                                            <th>Bukti Dukung</th>
                                            <th>Catatan Pegawai</th>
                                            <th>Nilai</th>
                                            <th>Catatan Penilai</th>
                                            <th>Aksi</th>
                                            <th class="never">Link Bukti Dukung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($realisasiDinilai as $realisasi)
                                            <tr>
                                                <td>{{ $realisasi->pelaksana->rencanaKerja->tugas }}</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-{{ $colorText[$realisasi->status] }}">{{ $status[$realisasi->status] }}</td>
                                                <td>
                                                    @if (file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja))
                                                        <a class="btn btn-primary"
                                                        href="{{ asset('document/realisasi/'.$realisasi->hasil_kerja) }}" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-primary"
                                                        href="{{ $realisasi->hasil_kerja }}" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif    
                                                </td>
                                                <td>{{ $realisasi->catatan }}</td>
                                                <td>{{ $realisasi->nilai }}</td>
                                                <td>{{ $realisasi->catatan_penilai }}</td>
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-primary dropdown-toggle no-arrow" 
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
    <script src="{{ asset('js/page/pegawai/penilaian-berjenjang.js') }}"></script>
@endpush
