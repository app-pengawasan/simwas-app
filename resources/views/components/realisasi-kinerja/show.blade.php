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
            @php $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja']; @endphp
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
                            <table class="mb-4 table table-striped responsive" id="table-show">
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
                                    <th>Jabatan</th>
                                    <td>{{ $jabatan[$realisasi->pelaksana->pt_jabatan] }}</td>
                                </tr>
                                <tr>
                                    <th>Hasil Kerja</th>
                                    <td>
                                        @if ($realisasi->pelaksana->pt_jabatan == 3)
                                            @if ($realisasi->pelaksana->pt_hasil == 2)
                                                Kertas Kerja
                                            @else
                                                {{ $hasilKerja[$realisasi->pelaksana->pt_hasil] }}
                                            @endif
                                        @elseif ($realisasi->pelaksana->pt_jabatan == 4)
                                            Kertas Kerja
                                        @else
                                            {{ $hasilKerja2[$realisasi->pelaksana->pt_hasil] }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Waktu</th>
                                    <td>
                                        {{ date("d-m-Y", strtotime($realisasi->tgl)) }}
                                        ({{ date("H:i", strtotime($realisasi->start)) }} - {{ date("H:i", strtotime($realisasi->end)) }})
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kegiatan</th>
                                    <td>{{ $realisasi->kegiatan }}</td>
                                </tr>
                                <tr>
                                    <th>Capaian</th>
                                    <td>{{ $realisasi->capaian }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="badge badge-{{ $colorText[$realisasi->status] }}">{{ $status[$realisasi->status] }}</span></td>
                                </tr>
                                <tr>
                                    <th>Bukti Dukung</th>
                                    <td>
                                        @if (file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja))
                                            <a class="btn btn-primary h-75 d-flex align-items-center justify-content-center" style="width: 10%"
                                            href="{{ asset('document/realisasi/'.$realisasi->hasil_kerja) }}" target="_blank">
                                                <i class="fas fa-eye"></i>
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
@endpush
