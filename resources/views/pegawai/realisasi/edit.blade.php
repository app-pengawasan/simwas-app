@extends('layouts.app')

@section('title', 'Edit Realisasi Kinerja')

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
                <h1>Form Edit Realisasi</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="{{  url()->previous() }}" id="btn-back">
                                        <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            @php $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja']; @endphp
                            <form enctype="multipart/form-data" name="myeditform" id="myeditform" class="needs-validation" novalidate="">
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id" value="{{ $realisasi->id }}">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tim">Tim</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tim" id="tim" required disabled>
                                                <option value="{{ $realisasi->pelaksana->rencanaKerja->proyek->timkerja->id_timkerja }}" selected>
                                                    {{ $realisasi->pelaksana->rencanaKerja->proyek->timkerja->nama }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="proyek">Proyek</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="proyek" id="proyek" required disabled>
                                                <option value="{{ $realisasi->pelaksana->rencanaKerja->proyek->id }}" selected>
                                                    {{ $realisasi->pelaksana->rencanaKerja->proyek->nama_proyek }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tugas">Tugas</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tugas" id="tugas" required disabled>
                                                @if ($realisasi->pelaksana->pt_jabatan == 3)
                                                    @if ($realisasi->pelaksana->pt_hasil == 2)
                                                        @php $hasil = 'Kertas Kerja'; @endphp
                                                    @else
                                                        @php $hasil = $hasilKerja[$realisasi->pelaksana->pt_hasil]; @endphp
                                                    @endif
                                                @elseif ($realisasi->pelaksana->pt_jabatan == 4)
                                                    @php $hasil = 'Kertas Kerja'; @endphp
                                                @else
                                                    @php $hasil = $hasilKerja2[$realisasi->pelaksana->pt_hasil]; @endphp
                                                @endif
                                                <option value="{{ $realisasi->id_pelaksana }}" data-hasil="{{ $hasil }}" selected>
                                                    {{ $realisasi->pelaksana->rencanaKerja->tugas }}
                                                </option>
                                            </select>
                                            <small id="error-tugas" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_pelaksana" value="{{ $realisasi->id_pelaksana }}">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="edit-aktivitas">Aktivitas</label>
                                        <div class="col-sm-10">
                                            <table id="edit-aktivitas">
                                                <tbody>
                                                    @foreach ($events as $event)
                                                        <tr data-tugas="{{ $event->id_pelaksana }}">
                                                            <td>{{ $event->start }} - {{ $event->end }}</td>
                                                            <td>: {{ $event->aktivitas }} </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- <input type="date" name="aktivitas" id="aktivitas" class="form-control" required> --}}
                                            {{-- <small id="error-tgl" class="text-danger"></small> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tgl">Tanggal</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tgl" id="tgl" class="form-control" 
                                            required value="{{ $realisasi->tgl }}">
                                            <small id="error-tgl" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group clockpicker" data-autoclose="true">
                                                <label class="form-label" for="start">Jam Mulai</label>
                                                <input type="text" name="start" id="start" class="form-control" 
                                                required value="{{ date("H:i", strtotime($realisasi->start)) }}">
                                                <small id="error-start" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group clockpicker" data-autoclose="true">
                                                <label class="form-label" for="end">Jam Selesai</label>
                                                <input type="text" name="end" id="end" class="form-control" required
                                                value="{{ date("H:i", strtotime($realisasi->end)) }}">
                                                <small id="error-end" class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="status">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" selected disabled>Pilih Status Realisasi</option>
                                                @foreach ($status as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('status', $realisasi->status) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="error-status" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row status_change">
                                        <label class="col-sm-2 col-form-label" for="kegiatan">Kegiatan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" class="form-control h-auto" 
                                                id="kegiatan" name="kegiatan" required>{{ $realisasi->kegiatan }}
                                            </textarea>
                                            <small id="error-kegiatan" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row status_change">
                                        <label class="col-sm-2 col-form-label" for="capaian">Capaian</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" class="form-control h-auto" 
                                                id="capaian" name="capaian" required>{{ $realisasi->capaian }}
                                            </textarea>
                                            <small id="error-capaian" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="edit-link">Hasil Kerja</label>
                                        <div class="col-sm-10">
                                            <input type="url" name="edit-link" id="edit-link" class="form-control" placeholder="Link Hasil Kerja"
                                                {{-- @if (!file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja)) --}}
                                                    value="{{ $realisasi->hasil_kerja }}"
                                                {{-- @endif --}}
                                            >
                                            <small id="error-edit-link" class="text-danger"></small>
                                            {{-- <div class="d-flex mt-3">
                                                <label for="edit-file" style="color: #34395e; width: 24%" class="mt-2">
                                                    <em>atau upload file</em>
                                                </label>
                                                <input type="file" class="form-control" id="edit-file" name="edit-file" accept=".pdf"
                                                    @if (!file_exists(public_path().'/document/realisasi/'.$realisasi->hasil_kerja)) 
                                                        disabled
                                                    @endif
                                                >
                                                <button type="button" class="btn btn-primary ml-2 h-100" id="edit-clear">
                                                    Clear
                                                </button>
                                            </div> --}}
                                            <small id="error-edit-file" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="catatan">Catatan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" class="form-control h-auto" name="catatan" id="catatan">{{ $realisasi->catatan }}</textarea>
                                            <small id="error-catatan" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right pr-1">
                                        <button type="submit" class="btn btn-primary edit-btn">
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
        document.forms['myeditform'].reset();
    </script>
    <script src="{{ asset('js/page/pegawai/realisasi.js') }}"></script>
@endpush
