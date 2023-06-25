@extends('layouts.app')

@section('title', 'Detail Rencana Kegiatan')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <!-- Modal -->
    @include('components.rencana-kerja.create');
    @include('components.rencana-kerja.summary');
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Tim kerja</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="/pegawai/rencana-kinerja">
                                        <i class="fas fa-chevron-circle-left"></i>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" name="id_timkerja" id="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                            <table class="mb-4">
                                <tr>
                                    <th style="min-width: 94pt">Tujuan</th>
                                    <td>{{ $timKerja->iku->sasaran->tujuan->tujuan }}</td>
                                </tr>
                                <tr>
                                    <th>Sasaran</th>
                                    <td>{{ $timKerja->iku->sasaran->sasaran }}</td>
                                </tr>
                                <tr>
                                    <th>IKU</th>
                                    <td>{{ $timKerja->iku->iku }}</td>
                                </tr>
                                <tr>
                                    <th>Kegiatan</th>
                                    <td>{{ $timKerja->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Kerja</th>
                                    <td>{{ $unitKerja[$timKerja->unitkerja] }}</td>
                                </tr>
                                <tr>
                                    <th>Ketua</th>
                                    <td>{{ $timKerja->ketua->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $timKerja->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Total Anggaran</th>
                                    <td class="rupiah">
                                        <?php $totalAnggaran = 0; ?>
                                        @foreach ($timKerja->rencanaKerja as $rk)
                                            <?php $totalAnggaran += $rk->anggaran->sum('total'); ?>
                                        @endforeach
                                        {{ $totalAnggaran }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $statusTim[$timKerja->status] }}</td>
                                </tr>
                            </table>
                            <div class="row mb-4 pb0">
                                <div class="col-md-12">
                                    @if ($timKerja->status < 2 || $timKerja->status == 3)
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            data-target="#modal-create-tugas">
                                            <i class="fas fa-plus-circle"></i>
                                            Tugas
                                        </button>
                                    @endif
                                    @if ($timKerja->status != 0)

                                        <button class="btn btn-warning" data-toggle="modal" data-target="#modal-summary">
                                            <i class="fas fa-receipt"></i> Ringkasan
                                        </button>
                                        @if ($timKerja->status < 2 || $timKerja->status == 3)
                                            <button class="btn btn-success" id="btn-send-rencana-kerja">
                                                <i class="fas fa-paper-plane"></i> Kirim
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-4 pb-0">
                                <div class="col-md-12">
                                    <h4>Tugas</h4>
                                    <ol>
                                        @foreach ($rencanaKerja as $tugas)
                                            <li class="my-2">
                                                {{ $tugas->tugas }}
                                                @if ($timKerja->status < 2 || $timKerja->status == 3)
                                                    <a href="/pegawai/tim-pelaksana/{{ $tugas->id_rencanakerja }}"
                                                        class="btn btn-warning edit-btn">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="javascript(0)" class="btn btn-danger delete-btn"
                                                        data-id="{{ $tugas->id_rencanakerja }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script> --}}
    <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js') }}/page/pimpinan-rencana-kerja.js"></script>
@endpush
