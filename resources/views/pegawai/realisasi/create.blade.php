@extends('layouts.app')

@section('title', 'Isi Realisasi Kinerja')

@push('clockpicker')
    <link rel="stylesheet" href="{{ asset('library') }}/clockpicker/jquery-clockpicker.min.css">
@endpush

@push('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Isi Realisasi</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="/pegawai/realisasi" id="btn-back">
                                        <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            @php $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja']; @endphp
                            <form enctype="multipart/form-data" name="myform" id="myform" class="needs-validation" novalidate="">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tim">Tim</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tim" id="tim" required>
                                                <option value="" selected disabled>Pilih Tim</option>
                                                @foreach ($timkerja as $id_tim => $nama_tim)
                                                    <option value="{{ $id_tim }}">
                                                        {{ $nama_tim }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tugas">Tugas</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tugas" id="tugas" required>
                                                <option value="" selected disabled class="disabled">Pilih Tugas</option>
                                                @foreach ($tugasSaya as $ts)
                                                    @if ($ts->pt_jabatan == 3)
                                                        @if ($ts->pt_hasil == 2)
                                                            @php $hasil = 'Kertas Kerja'; @endphp
                                                        @else
                                                            @php $hasil = $hasilKerja[$ts->pt_hasil]; @endphp
                                                        @endif
                                                    @elseif ($ts->pt_jabatan == 4)
                                                        @php $hasil = 'Kertas Kerja'; @endphp
                                                    @else
                                                        @php $hasil = $hasilKerja2[$ts->pt_hasil]; @endphp
                                                    @endif
                                                    <option value="{{ $ts->id_pelaksana }}"
                                                    data-tim="{{ $ts->rencanaKerja->id_timkerja }}"
                                                    data-hasil="{{ $hasil }}">
                                                        {{ $ts->rencanaKerja->tugas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="error-tugas" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tgl">Tanggal</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tgl" id="tgl" class="form-control" required>
                                            <small id="error-tgl" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group clockpicker" data-autoclose="true">
                                                <label class="form-label" for="start">Jam Mulai</label>
                                                <input type="text" name="start" id="start" class="form-control" required>
                                                <small id="error-start" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group clockpicker" data-autoclose="true">
                                                <label class="form-label" for="end">Jam Selesai</label>
                                                <input type="text" name="end" id="end" class="form-control" required>
                                                <small id="error-end" class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="status">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" selected disabled>Pilih Status Realisasi</option>
                                                @foreach ($status as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('status') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="error-status" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="kegiatan">Kegiatan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" class="form-control h-auto" id="kegiatan" name="kegiatan" required></textarea>
                                            <small id="error-kegiatan" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="capaian">Capaian</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" class="form-control h-auto" id="capaian" name="capaian" required></textarea>
                                            <small id="error-capaian" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="link">Hasil Kerja</label>
                                        <div class="col-sm-10">
                                            <input type="url" name="link" id="link" class="form-control" required placeholder="Link Hasil Kerja">
                                            <small id="error-link" class="text-danger"></small>
                                            <div class="d-flex mt-3 align-items-center">
                                                <label for="file" style="color: #34395e; width: 24%" class="mt-2">
                                                    <em>atau upload file</em>
                                                </label>
                                                <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                                <button type="button" class="btn btn-primary ml-2 h-100" id="clear">
                                                    Clear
                                                </button>
                                            </div>
                                            <small id="error-file" class="text-danger"></small>
                                            {{-- <div class="invalid-feedback">
                                                File belum ditambahkan
                                            </div>
                                            <small id="error-create-sertifikat" class="text-danger"></small> --}}
                                        </div>
                                        {{-- <small id="error-edit-tgl" class="text-danger"></small> --}}
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="catatan">Catatan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" class="form-control h-auto" name="catatan" id="catatan"></textarea>
                                            <small id="error-catatan" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right pr-1">
                                        <button type="submit" class="btn btn-primary submit-btn">
                                            <i class="fas fa-save"></i>
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    <script src="{{ asset('library') }}/clockpicker/jquery-clockpicker.js"></script>

    <!-- Page Specific JS File -->
    <script>
        var clockpicker = $('.clockpicker').clockpicker();
        document.forms['myform'].reset(); //clear form
    </script>
    <script src="{{ asset('js/page/pegawai/realisasi.js') }}"></script>
@endpush
