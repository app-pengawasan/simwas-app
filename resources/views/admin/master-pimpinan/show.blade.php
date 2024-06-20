@extends('layouts.app')

@section('title', 'Detail Pimpinan')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}"> --}}
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Pegawai</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="mb-4">
                                <tr>
                                    <th style="min-width: 160pt">NIP</th>
                                    <td>{{ $pimpinan->user->nip }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $pimpinan->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>E-mail</th>
                                    <td>{{ $pimpinan->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>{{ $jabatan_pimpinan["$pimpinan->jabatan"] }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Kerja</th>
                                    <?php
                                    $uj = $pimpinan->user->unit_kerja;
                                    ?>
                                    <td>{{ $unit_kerja["$uj"] }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row mb-0 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="{{ route('admin.master-pimpinan.index') }}">
                                        <i class="fas fa-chevron-circle-left"></i>
                                    </a>
                                    <a class="btn btn-warning" href="/admin/master-pegawai/{{ $pimpinan->user->id }}/edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if ($pimpinan->user->id != auth()->user()->id)
                                        <a class="btn btn-danger" href="http://">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif
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
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
