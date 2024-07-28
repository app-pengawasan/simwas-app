@extends('layouts.app')

@section('title', 'Kelola Kompetensi Pegawai')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @if ($role == 'analis-sdm')
        @include('components.analis-sdm-header')
        @include('components.analis-sdm-sidebar')
    @else
        @include('components.header')
        @include('components.pegawai-sidebar')
    @endif
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Kompetensi</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-8">                               
                                    <a class="btn btn-primary" href="{{  url()->previous() }}">
                                        <i class="fas fa-chevron-circle-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <table class="mb-4 table table-striped responsive">
                                @if ($role == 'analis-sdm')
                                    <tr>
                                        <th>Pegawai</th>
                                        <td>{{ $kompetensi->pegawai->name }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Jenis Pengembangan Kompetensi</th>
                                    @if ($kompetensi->pp->id == 999) <td>{{ $kompetensi->pp_lain }}</td>
                                    @else <td>{{ $kompetensi->pp->jenis }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Nama Pengembangan Kompetensi</th>
                                    @if ($kompetensi->namaPp->id == 999) <td>{{ $kompetensi->nama_pp_lain }}</td>
                                    @else <td>{{ $kompetensi->namaPp->nama }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $kompetensi->tgl_mulai }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $kompetensi->tgl_selesai }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>{{ $kompetensi->durasi }} jam</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sertifikat</th>
                                    <td>{{ $kompetensi->tgl_sertifikat }}</td>
                                </tr>
                                <tr>
                                    <th>Sertifikat</th>
                                    <td>
                                        <a class="btn btn-sm btn-primary"
                                        href="{{ asset('document/sertifikat/'.$kompetensi->sertifikat) }}" target="_blank">
                                            <i class="fas fa-eye mr-1"></i>Lihat
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <td>{{ $kompetensi->penyelenggaraDiklat->penyelenggara }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Peserta</th>
                                    <td>{{ $kompetensi->jumlah_peserta }}</td>
                                </tr>
                                <tr>
                                    <th>Ranking</th>
                                    <td>{{ $kompetensi->ranking }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $kompetensi->catatan }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($kompetensi->status == 1)
                                            <span class="badge badge-{{ $colorText[$kompetensi->status] }}">{{ $status[$kompetensi->status] }} oleh {{ $kompetensi->analis->name }}</span>
                                        @else
                                            <span class="badge badge-{{ $colorText[$kompetensi->status] }}">{{ $status[$kompetensi->status] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>
@endpush
