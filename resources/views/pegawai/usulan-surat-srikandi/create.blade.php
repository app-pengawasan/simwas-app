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
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Jenis Naskah Dinas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Naskah dinas penugasan</h6>
                    <ul>
                        <li>Surat Tugas</li>
                        <li>Surat Perintah</li>
                    </ul>
                    <h6 class="text-dark">Naskah Korespondensi</h6>
                    <ul>
                        <li>Surat Dinas</li>
                        <li>Nota Dinas</li>
                        <li>Memorandum</li>
                        <li>Undangan</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-dark" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- @include('components.kelola-kompetensi.create');
    @include('components.kelola-kompetensi.edit'); --}}
    <section class="section">
        <div class="section-header">
            <h1>Formulir Pengajuan Naskah Dinas untuk diproses pada Aplikasi Srikandi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="/pegawai/usulan-surat-srikandi">Usulan Surat Srikandi</a>
                </div>
                <div class="breadcrumb-item">Formulir Pengajuan Naskah Dinas</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('components.flash-error')
                        <div id="stepper1" class="bs-stepper">
                            <div class="bs-stepper-header mx-auto" style="width: 30%;">
                                <div class="step" data-target="#test-l-1">
                                    <button type="button" class="btn step-trigger d-flex flex-column">
                                        <span class="bs-stepper-circle">
                                            <i class="fa-solid fa-circle-info"></i></span>
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
                            <form id="logins-part" action="/pegawai/usulan-surat-srikandi" method="POST"
                                class="needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="bs-stepper-content">
                                    <div id="test-l-1" class="content">
                                        @csrf

                                        <div class="form-group">
                                            <label for="pejabatPenandaTangan">Pejabat Penanda Tangan</label>
                                            <select required
                                                class="form-control select2 @error('pejabatPenandaTangan') is-invalid @enderror"
                                                id="pejabatPenandaTangan" name="pejabatPenandaTangan">
                                                <option disabled selected value="">Pilih Pejabat Penanda Tangan</option>
                                                @foreach ($pejabatPenandaTangan as $key => $pejabatPenandaTangan)
                                                <option {{
                                                        old('pejabatPenandaTangan') == $key ? 'selected' : ''
                                                    }} value="{{ $key }}">
                                                    {{ $pejabatPenandaTangan }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Pejabat Penanda Tangan Harus Diisi</div>
                                        </div>

                                        <div class="form-group">
                                            <label for="jenisNaskahDinas">Jenis Naskah Dinas</label>
                                            <i class="fa-solid fa-circle-info" data-toggle="modal"
                                                data-target="#modalDetail" style="cursor: pointer"></i>
                                            <select required
                                                class="form-control select2 @error('jenisNaskahDinas') is-invalid @enderror"
                                                id="jenisNaskahDinas" name="jenisNaskahDinas">
                                                <option disabled selected value="">Pilih Jenis Naskah Dinas</option>
                                                @foreach ($jenisNaskahDinas as $key => $jenisNaskahDinas)
                                                <option {{
                                                        old('jenisNaskahDinas') == $jenisNaskahDinas ? 'selected' : ''
                                                    }} value="{{ $key }}">
                                                    {{ $jenisNaskahDinas }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Jenis Naskah Dinas Harus Diisi</div>
                                        </div>

                                        <div id="jenisNaskahDinasPenugasanWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="jenisNaskahDinasPenugasan">Jenis Naskah Dinas
                                                    Penugasan</label>
                                                <select required
                                                    class="form-control select2 @error('jenisNaskahDinasPenugasan') is-invalid @enderror"
                                                    id="jenisNaskahDinasPenugasan" name="jenisNaskahDinasPenugasan">
                                                    <option disabled selected value="">Pilih Jenis Naskah Dinas
                                                        Penugasan
                                                    </option>
                                                    @foreach ($jenisNaskahDinasPenugasan as $key => $jndp)
                                                    <option {{
                                                        old('jenisNaskahDinasPenugasan') == $key ? 'selected' : ''
                                                    }} value="{{ $key }}">
                                                        {{ $jndp }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Jenis Naskah Dinas Penugasan Harus Diisi
                                                </div>
                                            </div>
                                        </div>

                                        <div id="kegiatanWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="kegiatan">Kegiatan</label>
                                                <select required
                                                    class="form-control select2 @error('kegiatan') is-invalid @enderror"
                                                    id="kegiatan" name="kegiatan">
                                                    <option disabled selected value="">Pilih Kegiatan</option>
                                                    @foreach ($kegiatan as $key => $kegiatan)
                                                    <option {{ old('kegiatan') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">
                                                        {{ $kegiatan }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Kegiatan Harus Diisi</div>
                                            </div>
                                        </div>

                                        <div id="kegiatanPengawasanWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="kegiatanPengawasan">Kegiatan Pengawasan</label>
                                                <select required
                                                    class="form-control select2 @error('kegiatanPengawasan') is-invalid @enderror"
                                                    id="kegiatanPengawasan" name="kegiatanPengawasan">
                                                    <option disabled selected value="">Pilih Kegiatan Pengawasan
                                                    </option>
                                                    @foreach ($kegiatanPengawasan as $key => $kegiatanPengawasan)
                                                    <option {{ old('kegiatanPengawasan') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">
                                                        {{ $kegiatanPengawasan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="pendukungPengawasanWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="pendukungPengawasan">Pendukung Pengawasan</label>
                                                <select required
                                                    class="form-control select2 @error('pendukungPengawasan') is-invalid @enderror"
                                                    id="pendukungPengawasan" name="pendukungPengawasan">
                                                    <option disabled selected value="">Pilih Pendukung Pengawasan
                                                    </option>
                                                    @foreach ($pendukungPengawasan as $key => $pendukungPengawasan)
                                                    <option {{ old('pendukungPengawasan') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">
                                                        {{ $pendukungPengawasan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="jenisNaskahDinasKorespondensiWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="jenisNaskahDinasKorespondensi">Jenis Naskah Dinas
                                                    Korespondensi</label>
                                                <select required
                                                    class="form-control select2 @error('jenisNaskahDinasKorespondensi') is-invalid @enderror"
                                                    id="jenisNaskahDinasKorespondensi"
                                                    name="jenisNaskahDinasKorespondensi">
                                                    <option disabled selected value="">Pilih Jenis Naskah Dinas
                                                        Korespondensi
                                                    </option>
                                                    @foreach ($jenisNaskahDinasKorespondensi as $key => $jndk)
                                                    <option {{
                                                        old('jenisNaskahDinasKorespondensi') == $key ? 'selected' : ''
                                                    }} value="{{ $key }}">
                                                        {{ $jndk }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Jenis Naskah Dinas Korespondensi Harus
                                                    Diisi
                                                </div>
                                            </div>
                                        </div>

                                        <div id="unsurTugasWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="unsurTugas">Unsur Tugas</label>
                                                <select required
                                                    class="form-control select2 @error('unsurTugas') is-invalid @enderror"
                                                    id="unsurTugas" name="unsurTugas">
                                                    <option disabled selected value="">Pilih Unsur Tugas</option>
                                                    @foreach ($unsurTugas as $key => $unsurTugas)
                                                    <option {{ old('unsurTugas') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">
                                                        {{ $unsurTugas }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Unsur Tugas Harus Diisi</div>
                                            </div>
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
                                                    {{ old('derajatKeamanan') == $derajatKeamanan ? 'selected' : '' }}
                                                    value="{{ $derajatKeamanan }}">
                                                    {{ $derajatKeamanan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Derajat Kemanan Harus Diisi</div>
                                        </div>

                                        <div id="perihalWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="perihal">Perihal</label>
                                                <input required placeholder="Uraian Singkat isi surat" type="text"
                                                    class="form-control @error('perihal') is-invalid @enderror"
                                                    id="perihal" name="perihal" value="{{ old('perihal') }}">
                                                <div class="invalid-feedback">Perihal Harus Diisi</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="kodeKlasifikasiArsip">Kode Klasifikasi Arsip</label>
                                            <select required class="form-control select2
                                                @error('kodeKlasifikasiArsip') is-invalid @enderror"
                                                id=" kodeKlasifikasiArsip" name="kodeKlasifikasiArsip">
                                                <option disabled selected value="">Pilih Kode Klasifikasi Arsip</option>
                                                @foreach ($kodeKlasifikasiArsip as $kodeKlasifikasiArsip)
                                                <option
                                                    {{ old('kodeKlasifikasiArsip') == $kodeKlasifikasiArsip ? 'selected' : '' }}
                                                    value="{{ $kodeKlasifikasiArsip }}">
                                                    {{ $kodeKlasifikasiArsip }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Kode Klasifikasi Arsip Harus Diisi</div>
                                        </div>
                                        {{-- create input untuk melaksanakan --}}
                                        <div id="melaksanakanWrapper" class="d-none">
                                            <div class="form-group">
                                                <label for="melaksanakan">Melaksanakan</label>
                                                <input required placeholder="Input Untuk Melaksanakan" type="text"
                                                    class="form-control @error('melaksanakan') is-invalid @enderror"
                                                    id="melaksanakan" name="melaksanakan"
                                                    value="{{ old('melaksanakan') }}">
                                                <div class="invalid-feedback">Melaksanakan Harus Diisi</div>
                                            </div>
                                        </div>

                                        {{-- create input untuk menimbang --}}
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
                                                value="{{ old('usulanTanggal') }}">
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
                                    <div  id="file-upload-wrapper" class="form-group">
                                        <label for="customFile">Upload Dokumen Naskah Dinas</label>
                                        <div class="custom-file">
                                            <input required name="file" type="file" class="custom-file-input @error('file')
                                                is-invalid @enderror" id="customFile" accept=".doc, .docx"
                                                @error('file') is-invalid @enderror>
                                            <label class="custom-file-label" for="customFile">Pilih Dokumen Naskah
                                                Dinas</label>
                                            <div class="invalid-feedback pt-1">Unggah Dokumen Naskah Dinas</div>
                                        </div>
                                    </div>
                                    <div id="surat-tugas-wrapper">
                                        <div class="form-group">
                                            <label for="rencana_id">Tugas</label>
                                            <select required id="rencana_id" name="rencana_id"
                                                class="form-control select2 @error('rencana_id') is-invalid @enderror">
                                                <option value="">Pilih tugas</option>
                                                @foreach ($rencanaKerja as $rencana)
                                                <option value="{{ $rencana->id_rencanakerja }}"
                                                    {{ old('rencana_id') == $rencana->id_rencanakerja ? 'selected' : '' }}>
                                                    {{ $rencana->tugas }}</option>
                                                @endforeach
                                            </select>
                                            @error('rencana_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="tim_kerja">Tim Kerja</label>
                                            <input  type="text" readonly
                                                class="form-control @error('tim_kerja') is-invalid @enderror"
                                                id="tim_kerja" name="tim_kerja" value="{{ old('tim_kerja') }}">
                                            @error('tim_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Pelaksana Tugas</label>
                                            <ul id="pelaksana-tugas" class="list-group">
                                            </ul>
                                        </div>

                                        <div>
                                            <div class="form-group
                                        {{-- text area --}}
                                        @if ($errors->has('menimbang'))
                                            has-error
                                        @endif">
                                                <label for="menimbang">Menimbang</label>
                                                <textarea required style="height: 100px"
                                                    class="form-control @error('menimbang') is-invalid @enderror"
                                                    id="menimbang" name="menimbang"
                                                    value="{{ old('menimbang') }}"></textarea>
                                                <div class="invalid-feedback">Menimbang Harus Diisi</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group
                                        @if ($errors->has('mengingat')) has-error
                                        @endif">
                                                <label for="mengingat">Mengingat</label>
                                                <textarea required style="height: 100px"
                                                    class="form-control @error('mengingat') is-invalid @enderror"
                                                    id="mengingat" name="mengingat"
                                                    value="{{ old('mengingat') }}"></textarea>
                                                <div class="invalid-feedback">Mengingat Harus Diisi</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group @if ($errors->has('untuk')) has-error
                                                                            @endif">
                                                <label for="untuk">Untuk</label>
                                                <textarea required style="height: 100px"
                                                    class="form-control @error('untuk') is-invalid @enderror" id="untuk"
                                                    name="untuk" value="{{ old('untuk') }}"></textarea>
                                                <div class="invalid-feedback">Untuk Harus Diisi</div>
                                            </div>
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
