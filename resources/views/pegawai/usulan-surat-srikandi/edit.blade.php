@extends('layouts.app')

@section('title', 'Usulan Surat Srikandi')

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
@include('components.header')
@include('components.pegawai-sidebar')

<div class="main-content">
    <!-- Modal -->
    {{-- @include('components.kelola-kompetensi.create');
    @include('components.kelola-kompetensi.edit'); --}}
    <section class="section">
        <div class="section-header">
            <h1>Formulir Pengajuan Naskah Dinas untuk diproses pada Aplikasi Srikandi</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash-error');
                        <div id="stepper1" class="bs-stepper">
                            <div class="bs-stepper-header mx-auto" style="width: 30%;">
                                <div class="step" data-target="#test-l-1">
                                    <button type="button" class="btn step-trigger d-flex flex-column">
                                        <span class="bs-stepper-circle"><i class="fa-solid fa-circle-info"></i></span>
                                        <span class="bs-stepper-label">Data Surat</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#test-l-2">
                                    <button type="button" class="btn step-trigger d-flex flex-column">
                                        <span class="bs-stepper-circle"><i class="fa-solid fa-paragraph"></i></span>
                                        <span class="bs-stepper-label">Isi Surat</span>
                                    </button>
                                </div>
                            </div>
                            <form method="POST" id="logins-part"
                                action="{{ route('usulan-surat-srikandi.update', $usulanSuratSrikandi->id) }}"
                                class="needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="bs-stepper-content">
                                    <div id="test-l-1" class="content">
                                        @csrf
                                        <div class="form-group">
                                            <label for="pejabatPenandaTangan">Pejabat Penanda Tangan</label>
                                            <select required
                                                class="form-control select2 @error('pejabatPenandaTangan') is-invalid @enderror"
                                                id="pejabatPenandaTangan" name="pejabatPenandaTangan">
                                                <option disabled selected value="">Pilih Pejabat Penanda Tangan</option>
                                                @foreach ($pejabatPenandaTangan as $pejabatPenandaTangan)
                                                <option {{
                                                    old('pejabatPenandaTangan') == $pejabatPenandaTangan || $usulanSuratSrikandi->pejabat_penanda_tangan == $pejabatPenandaTangan ? 'selected' : ''
                                                }} value="{{ $pejabatPenandaTangan }}">
                                                    {{ $pejabatPenandaTangan }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Pejabat Penanda Tangan Harus Diisi</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenisNaskahDinas">Jenis Naskah Dinas</label>
                                            <select required
                                                class="form-control select2 @error('jenisNaskahDinas') is-invalid @enderror"
                                                id="jenisNaskahDinas" name="jenisNaskahDinas">
                                                <option disabled selected value="">Pilih Jenis Naskah Dinas</option>
                                                @foreach ($jenisNaskahDinas as $jenisNaskahDinas)
                                                <option {{
                                                        old('jenisNaskahDinas') == $jenisNaskahDinas || $usulanSuratSrikandi->jenis_naskah_dinas == $jenisNaskahDinas ? 'selected' : ''
                                                    }} value="{{ $jenisNaskahDinas }}">
                                                    {{ $jenisNaskahDinas }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Jenis Naskah Dinas Harus Diisi</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenisNaskahDinasPenugasan">Jenis Naskah Dinas
                                                Penugasan</label>
                                            <select required
                                                class="form-control select2 @error('jenisNaskahDinasPenugasan') is-invalid @enderror"
                                                id="jenisNaskahDinasPenugasan" name="jenisNaskahDinasPenugasan">
                                                <option disabled selected value="">Pilih Jenis Naskah Dinas Penugasan
                                                </option>
                                                @foreach ($jenisNaskahDinasPenugasan as $jndp)
                                                <option {{
                                                        old('jenisNaskahDinasPenugasan') == $jndp || $usulanSuratSrikandi->jenis_naskah_dinas_penugasan == $jndp ? 'selected' : ''
                                                    }} value="{{ $jndp }}">
                                                    {{ $jndp }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Jenis Naskah Dinas Penugasan Harus Diisi</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="kegiatan">Kegiatan</label>
                                            <select required
                                                class="form-control select2 @error('kegiatan') is-invalid @enderror"
                                                id="kegiatan" name="kegiatan">
                                                <option disabled selected value="">Pilih Kegiatan</option>
                                                @foreach ($kegiatan as $kegiatan)
                                                <option
                                                    {{ old('kegiatan') == $kegiatan || $usulanSuratSrikandi->kegiatan == $kegiatan ? 'selected' : '' }}
                                                    value="{{ $kegiatan }}">
                                                    {{ $kegiatan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Kegiatan Harus Diisi</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="derajatKeamanan">Derajat Keamanan</label>
                                            <select required
                                                class="form-control select2 @error('derajatKeamanan') is-invalid @enderror"
                                                id="derajatKeamanan" name="derajatKeamanan">
                                                <option disabled selected value="">Pilih Kegiatan Derajat Keamanan
                                                </option>
                                                @foreach ($derajatKeamanan as $derajatKeamanan)
                                                <option
                                                    {{ old('derajatKeamanan') == $derajatKeamanan || $usulanSuratSrikandi->derajat_keamanan == $derajatKeamanan ? 'selected' : '' }}
                                                    value="{{ $derajatKeamanan }}">
                                                    {{ $derajatKeamanan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Derajat Kemanan Harus Diisi</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="kodeKlasifikasiArsip">Kode Klasifikasi Arsip</label>
                                            <select required class="form-control select2
                                                @error('kodeKlasifikasiArsip') is-invalid @enderror"
                                                id=" kodeKlasifikasiArsip" name="kodeKlasifikasiArsip">
                                                <option disabled selected value="">Pilih Kode Klasifikasi Arsip</option>
                                                @foreach ($kodeKlasifikasiArsip as $kodeKlasifikasiArsip)
                                                <option
                                                    {{ old('kodeKlasifikasiArsip') == $kodeKlasifikasiArsip || $usulanSuratSrikandi->kode_klasifikasi_arsip == $kodeKlasifikasiArsip ? 'selected' : '' }}
                                                    value="{{ $kodeKlasifikasiArsip }}">
                                                    {{ $kodeKlasifikasiArsip }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Kode Klasifikasi Arsip Harus Diisi</div>
                                        </div>
                                        {{-- create input untuk melaksanakan --}}
                                        <div class="form-group">
                                            <label for="melaksanakan">Melaksanakan</label>
                                            <input required placeholder="Input Untuk Melaksanakan" type="text"
                                                class="form-control @error('melaksanakan') is-invalid @enderror"
                                                id="melaksanakan" name="melaksanakan"
                                                value="{{ old('melaksanakan', $usulanSuratSrikandi->melaksanakan) }}">
                                            <div class="invalid-feedback">Melaksanakan Harus Diisi</div>
                                        </div>
                                        {{-- create date input with label Usulan Tanggal Penandatangan --}}
                                        <div class="form-group
                                            @if ($errors->has('usulanTanggal'))
                                                has-error
                                            @endif">
                                            <label for="usulanTanggal">Usulan Tanggal
                                                Penandatangan</label>
                                            <input required
                                                {{ old('usulanTanggal') ? 'value=' . old('usulanTanggal') : '' }}
                                                type="date"
                                                class="form-control @error('usulanTanggal') is-invalid @enderror"
                                                id="usulanTanggal" name="usulanTanggal"
                                                value="{{ old('usulanTanggal', $usulanSuratSrikandi->usulan_tanggal_penandatanganan) }}">
                                            <div class="invalid-feedback">Usulan Tanggal
                                                Penandatangan Harus Diisi</div>
                                        </div>

                                        <div class="text-right">
                                            <button onclick="stepper1.next()" type="button" class="btn btn-primary"
                                                id="next-form">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="test-l-2" class="content">


                                    <div class="form-group">
                                        {{-- <a href="{{ '/usulan-surat-srikandi/' . $usulanSuratSrikandi->directory }}"
                                        type="button" class="btn btn-primary" id="directory" data-toggle="modal"
                                        data-target="#file-modal">Lihat File</a> --}}
                                        <label for="customFile">Upload Dokumen Naskah Dinas</label>
                                        <div class="custom-file">
                                            <input required name="file" type="file" class="custom-file-input @error('file')
                                                is-invalid @enderror" id="customFile" accept=".doc, .docx"
                                                @error('file') is-invalid @enderror>
                                            <label class="custom-file-label" for="customFile">Pilih Dokumen Naskah
                                                Dinas</label>
                                            <div class="invalid-feedback">Unggah Dokumen Naskah Dinas</div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class=" btn btn-primary"
                                            onclick="stepper1.previous()">Previous</button>
                                        <button type="submit" class="btn btn-primary"
                                            onclick="stepper1.next()">Submit</button>
                                    </div>
                                </div>
                            </form>
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
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
<script src="{{ asset('library') }}/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="{{ asset('js') }}/page/pegawai/usulan-surat-srikandi/create.js"></script>

<!-- Page Specific JS File -->
@endpush