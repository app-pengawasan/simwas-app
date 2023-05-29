@extends('layouts.app')

@section('title', 'Surat Lain')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('header-app')
@endsection
@section('sidebar')
@endsection

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Surat Lain</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/surat-lain">Surat Lain</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @if ($usulan->status == 2 || $usulan->status == 4)
                                <div class="card-header">
                                    <h4>{{ ($usulan->status == 2) ? 'Upload File' : 'Upload Ulang File' }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="pt-1 pb-1 m-4">
                                        <form action="/pegawai/surat-lain/{{ $usulan->id }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="no_surat">No. Surat</label>
                                                <input type="hidden" name="status" value="{{ $usulan->status }}">
                                                <input type="hidden" name="no_surat" value="{{ $usulan->no_surat }}">
                                                <input type="hidden" name="surat" value="{{ $usulan->surat }}">
                                                <input type="text" class="form-control @error('no_surat') is-invalid @enderror" id="no_surat" value="{{ old('no_surat', $usulan->no_surat) }}" disabled>
                                                @error('no_surat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="surat">Pilih File</label>
                                                <input type="file" class="form-control @error('surat') is-invalid @enderror" name="surat" accept="application/pdf" id="surat" value="{{ old('surat', $usulan->surat) }}">
                                                @error('surat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-success">Upload</button>
                                        </form>
                                    </div>
                                </div>
                            @elseif ($usulan->status == 1)
                            <div class="card-header">
                                <h4>Edit Usulan Nomor</h4>
                            </div>
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                    <form action="/pegawai/surat-lain/{{ $usulan->id }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                        <input type="hidden" name="status" value="1">
                                        <div class="form-group">
                                            <label for="kegiatan">Kegiatan</label>
                                            <select id="kegiatan" name="kegiatan" class="form-control select2 @error('kegiatan') is-invalid @enderror">
                                                <option value="">Pilih kegiatan</option>
                                                <option value="1" {{ (old('kegiatan') == '1' || $usulan->kegiatan == '1') ? 'selected' : '' }}>Option 1</option>
                                                <option value="2" {{ (old('kegiatan') == '2' || $usulan->kegiatan == '2') ? 'selected' : '' }}>Option 2</option>
                                                <option value="3" {{ (old('kegiatan') == '3' || $usulan->kegiatan == '3') ? 'selected' : '' }}>Option 3</option>
                                                <option value="4" {{ (old('kegiatan') == '4' || $usulan->kegiatan == '4') ? 'selected' : '' }}>Option 4</option>
                                                <option value="5" {{ (old('kegiatan') == '5' || $usulan->kegiatan == '5') ? 'selected' : '' }}>Option 5</option>
                                            </select>
                                            @error('kegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="subkegiatan">Subkegiatan</label>
                                            <select id="subkegiatan" name="subkegiatan" class="form-control select2 @error('subkegiatan') is-invalid @enderror">
                                                <option value="">Pilih subkegiatan</option>
                                                <option value="1" {{ (old('subkegiatan') == '1' || $usulan->subkegiatan == '1') ? 'selected' : '' }}>Option 1</option>
                                                <option value="2" {{ (old('subkegiatan') == '2' || $usulan->subkegiatan == '2') ? 'selected' : '' }}>Option 2</option>
                                                <option value="3" {{ (old('subkegiatan') == '3' || $usulan->subkegiatan == '3') ? 'selected' : '' }}>Option 3</option>
                                                <option value="4" {{ (old('subkegiatan') == '4' || $usulan->subkegiatan == '4') ? 'selected' : '' }}>Option 4</option>
                                                <option value="5" {{ (old('subkegiatan') == '5' || $usulan->subkegiatan == '5') ? 'selected' : '' }}>Option 5</option>
                                            </select>
                                            @error('subkegiatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_surat_id">Jenis Surat</label>
                                            <select id="jenis_surat_id" name="jenis_surat_id" class="form-control select2 @error('jenis_surat_id') is-invalid @enderror">
                                                <option value="">Pilih jenis surat</option>
                                                <option value="1" {{ (old('jenis_surat_id') == '1' || $usulan->jenis_surat_id == '1') ? 'selected' : '' }}>Surat Undangan</option>
                                                <option value="2" {{ (old('jenis_surat_id') == '2' || $usulan->jenis_surat_id == '2') ? 'selected' : '' }}>Surat A</option>
                                                <option value="3" {{ (old('jenis_surat_id') == '3' || $usulan->jenis_surat_id == '3') ? 'selected' : '' }}>Surat B</option>
                                                <option value="4" {{ (old('jenis_surat_id') == '4' || $usulan->jenis_surat_id == '4') ? 'selected' : '' }}>Surat C</option>
                                                <option value="5" {{ (old('jenis_surat_id') == '5' || $usulan->jenis_surat_id == '5') ? 'selected' : '' }}>Surat D</option>
                                            </select>
                                            @error('jenis_surat_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', $usulan->tanggal) }}">
                                            @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="kka">KKA</label>
                                            <select id="kka" name="kka" class="form-control select2 @error('kka') is-invalid @enderror">
                                                <option value="">Pilih KKA</option>
                                                <option value="1" {{ (old('kka') == '1' || $usulan->kka == '1') ? 'selected' : '' }}>KKA 1</option>
                                                <option value="2" {{ (old('kka') == '2' || $usulan->kka == '2') ? 'selected' : '' }}>KKA 2</option>
                                                <option value="3" {{ (old('kka') == '3' || $usulan->kka == '3') ? 'selected' : '' }}>KKA 3</option>
                                                <option value="4" {{ (old('kka') == '4' || $usulan->kka == '4') ? 'selected' : '' }}>KKA 4</option>
                                                <option value="5" {{ (old('kka') == '5' || $usulan->kka == '5') ? 'selected' : '' }}>KKA 5</option>
                                            </select>
                                            @error('kka')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
