@extends('layouts.app')

@section('title', 'Norma Hasil')

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS Libraries -->
<link
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/date-1.4.1/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/rg-1.3.1/rr-1.3.3/sc-2.1.1/sb-1.4.2/sp-2.1.2/sl-1.6.2/sr-1.2.2/datatables.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('library') }}/bs-stepper/dist/css/bs-stepper.min.css">
@endpush

@section('main')
@include('components.arsiparis-header')
@include('components.arsiparis-sidebar')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah Norma Hasil</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash-error')
                        <form method="POST"
                            action="{{ route('arsiparis.norma-hasil.update-norma-hasil', $normaHasilUsulan->id) }}"
                            id="logins-part" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <h1 class="h4 text-dark mb-4 header-card">Ubah Norma Hasil</h1>
                            {{-- nama --}}
                            <div class="form-group
                                @error('nama_pengusul') is-invalid @enderror">
                                <label for="nama_pengusul">Nama Pengusul</label>
                                <select id="nama_pengusul" name="nama_pengusul"
                                    class="form-control select2 @error('nama_pengusul') is-invalid @enderror"
                                    data-placeholder="Pilih Pengusul">
                                    <option value=""></option>
                                    @foreach ($pengusul as $pengusul)
                                    <option value="{{ $pengusul->id }}"
                                        {{ $pengusul->id == $normaHasilUsulan->user_id ? 'selected' : '' }}>
                                        {{ old('nama_pengusul') == $pengusul->id ? 'selected' : '' }}
                                        {{ $pengusul->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('nama_pengusul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="unit_kerja">Unit Kerja</label>
                                <select class="form-control select2" name="unit_kerja" required>
                                    @foreach ($unit_kerja as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- tim kerja --}}
                            <div class="form-group">
                                <label for="tim_kerja">Tim Kerja</label>
                                <select id="tim_kerja" name="tim_kerja"
                                    class="form-control select2 @error('tim_kerja') is-invalid @enderror"
                                    data-placeholder="Pilih Tim Kerja">
                                    <option value=""></option>
                                    @foreach ($timKerja as $tim)
                                    <option value="{{ $tim->id_timkerja }}"
                                        {{ $tim->id_timkerja == ($normaHasilUsulan->rencanaKerja->timKerja->id_timkerja ?? null) ? 'selected' : '' }}
                                        {{ old('tim_kerja') == $tim->id_timkerja ? 'selected' : '' }}>
                                        {{ $tim->nama }}</option>
                                    @endforeach
                                </select>
                                @error('tim_kerja')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rencana_id">Tugas</label>
                                <select id="rencana_id" name="rencana_id"
                                    class="form-control select2 @error('rencana_id') is-invalid @enderror"
                                    data-placeholder="Pilih Tugas" disabled>
                                    <option value="{{ $normaHasilUsulan->tugas_id ?? '' }}">
                                        {{ $normaHasilUsulan->rencanaKerja->tugas ?? ''}}</option>
                                </select>
                                </select>
                                @error('rencana_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- Objek Kegiatan --}}
                            <div class="form-group
                                @if ($errors->has('objek_kegiatan')) is-invalid @endif">
                                <label for="objek_kegiatan">Objek Kegiatan</label>
                                <select id="objek_kegiatan" name="objek_kegiatan"
                                    data-placeholder="{{ $normaHasilUsulan->laporanPengawasan->objekPengawasan->nama ?? 'Pilih objek kegiatan' }}"
                                    class="form-control select2" disabled>
                                    <option value=""></option>
                                </select>
                                @if ($errors->has('objek_kegiatan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('objek_kegiatan') }}
                                </div>
                                @endif
                            </div>

                            {{-- Bulan Pelaporan --}}
                            <div class="form-group
                                                                @if ($errors->has('bulan_laporan')) is-invalid @endif">
                                <label for="bulan_pelaporan">Bulan Pelaporan</label>
                                <select id="bulan_pelaporan" name="bulan_pelaporan"
                                    data-placeholder="{{ $months[$normaHasilUsulan->laporanPengawasan->month ?? '0'] }}"
                                    class="form-control select2" disabled>
                                    class="form-control select2">
                                    <option value=""></option>
                                </select>
                                @if ($errors->has('bulan_pelaporan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('objek_kegiatan') }}
                                </div>
                                @endif
                            </div>
                            {{-- Jenis Norma Hasil --}}
                            <div class="form-group
                                @if ($errors->has('jenis_norma_hasil')) is-invalid @endif">
                                <label for="jenis_norma_hasil">Pilih Jenis Laporan</label>
                                <select id="jenis_norma_hasil" name="jenis_norma_hasil" class="form-control select2"
                                    data-placeholder="Pilih Jenis Laporan">
                                    <option value=""></option>
                                    @foreach ($masterLaporan as $masterLaporan)
                                    <option value="{{ $masterLaporan->id }}"
                                        {{ $normaHasilUsulan->jenis_norma_hasil_id == $masterLaporan->id ? 'selected' : '' }}>
                                        {{ $masterLaporan->kode }} - {{ $masterLaporan->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('jenis_norma_hasil'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jenis_norma_hasil') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group
                                @if ($errors->has('file')) is-invalid @endif">
                                <label for="url_norma_hasil">Link Dokumen</label>
                                <input placeholder="Masukkan URL/Link dokumen" type="url" id="url_norma_hasil"
                                    name="url_norma_hasil" class="form-control"
                                    value="{{ $normaHasilUsulan->document_path }}">
                                @if ($errors->has('url_norma_hasil'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('url-norma-hasil') }}
                                </div>
                                @endif
                            </div>
                            {{-- date Tanggal Norma Hasil --}}
                            <div class="form-group
                                @error('tanggal_norma_hasil') is-invalid @enderror">
                                <label for="tanggal_norma_hasil">Tanggal Norma Hasil</label>
                                <input type="date" id="tanggal_norma_hasil" name="tanggal_norma_hasil"
                                    class="form-control @error('tanggal_norma_hasil') is-invalid @enderror"
                                    value="{{ $normaHasilUsulan->tanggal }}">
                                @error('tanggal_norma_hasil')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex mt-4" style="gap: 10px">
                                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">
                                    <i class="fa-solid fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>
                                <button class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
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
<script src="{{ asset('library') }}/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="{{ asset('js') }}/page/arsiparis/edit.js"></script>

<!-- Page Specific JS File -->
@endpush
