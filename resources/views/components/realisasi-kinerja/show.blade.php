@extends('layouts.app')

@section('title', 'Realisasi Kinerja')

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @if ($kembali == 'nilai-inspektur')
        @include('components.inspektur-header')
        @include('components.inspektur-sidebar')
    @else
        @include('components.header')
        @include('components.pegawai-sidebar')
    @endif
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Realisasi</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-8">                               
                                    @if ($kembali == 'realisasi')
                                        <a class="btn btn-primary" href="/pegawai/realisasi">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>     
                                        <a class="btn btn-warning" href="/pegawai/realisasi/{{ $realisasi->id }}/edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                                            data-id="{{ $realisasi->id }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    @else 
                                        <a class="btn btn-primary" href="{{  url()->previous() }}">
                                            <i class="fas fa-chevron-circle-left"></i> Kembali
                                        </a>   
                                    @endif
                                </div>
                            </div>
                            <table class="mb-4 table table-striped responsive">
                                <tr>
                                    <th>Tim</th>
                                    <td>{{ $realisasi->pelaksana->rencanaKerja->proyek->timkerja->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Proyek</th>
                                    <td>{{ $realisasi->pelaksana->rencanaKerja->proyek->nama_proyek }}</td>
                                </tr>
                                <tr>
                                    <th>Tugas</th>
                                    <td>{{ $realisasi->pelaksana->rencanaKerja->tugas }}</td>
                                </tr>
                                <tr>
                                    <th>Objek Pengawasan</th>
                                    <td>{{ $realisasi->laporanObjekPengawasan->objekPengawasan->nama }}</td>
                                </tr>
                                @php
                                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 
                                                'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                <tr>
                                    <th>Bulan Pelaporan</th>
                                    <td>{{ $months[$realisasi->laporanObjekPengawasan->month - 1] }}</td>
                                </tr>
                                <tr>
                                    <th>Peran</th>
                                    <td>{{ $jabatan[$realisasi->pelaksana->pt_jabatan] }}</td>
                                </tr>
                                <tr>
                                    <th>Hasil Kerja</th>
                                    <td>
                                        {{ $realisasi->pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $realisasi->pelaksana->pt_jabatan )->first()->hasil_kerja }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Aktivitas</th>
                                    <td>    
                                        <table id="aktivitas" class="table table-striped responsive mt-3">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 25%">Tanggal</th>
                                                    <th style="width: 25%">Waktu</th>
                                                    <th>Aktivitas</th>
                                                    <td class="d-none">jam</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($events as $event) 
                                                    @php
                                                        $start = $event->start;
                                                        $end = $event->end;
                                                    @endphp
                                                    <tr data-tugas="{{ $event->id_pelaksana }}" class="text-center show">
                                                        <td class="p-0">{{ date("j F Y",strtotime($start)) }}</td>
                                                        <td>{{ date("H:i",strtotime($start)) }} - {{ date("H:i",strtotime($end)) }}</td>
                                                        <td style="white-space: pre-line;">{{ $event->aktivitas }} </td>
                                                        <td class="jam d-none">{{ (strtotime($end) - strtotime($start)) / 60 / 60 }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jam Realisasi</th>
                                    <td id="jam"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="badge badge-{{ $colorText[$realisasi->status] }}">{{ $status[$realisasi->status] }}</span></td>
                                </tr>
                                <tr>
                                    <th>Rencana Kerja</th>
                                    <td>{{ $realisasi->rencana_kerja }}</td>
                                </tr>
                                <tr>
                                    <th>IKI</th>
                                    <td>{{ $realisasi->iki }}</td>
                                </tr>
                                <tr>
                                    <th>Kegiatan</th>
                                    <td>{{ $realisasi->kegiatan }}</td>
                                </tr>
                                <tr>
                                    <th>Capaian</th>
                                    <td>{{ $realisasi->capaian }}</td>
                                </tr>
                                @if ($realisasi->status == 1)
                                    <tr>
                                        <th>Bukti Dukung</th>
                                        <td>
                                            @if (file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja))
                                                <a class="btn btn-primary h-75 d-flex align-items-center justify-content-center" style="width: 10%"
                                                href="{{ asset('document/realisasi/'.$realisasi->hasil_kerja) }}" target="_blank">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-primary h-75 d-flex align-items-center justify-content-center" style="width: 10%"
                                                href="{{ $realisasi->hasil_kerja }}" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>{{ $realisasi->catatan }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <th>Alasan</th>
                                        <td>{{ $realisasi->alasan }}</td>
                                    </tr>
                                @endif
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/pegawai/realisasi.js') }}"></script>
    <script>
        let i = 0;
        $(`.jam`).each(function() {
            i = i + +$(this).text();
        });
        $('#jam').text(i);

        $('.show').show();
    </script>
@endpush
