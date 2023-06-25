@extends('layouts.app')

@section('title', 'Tambah Pimpinan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Tambah Pimpinan</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="javascript(0);" id="btn-back">
                                        <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('master-pimpinan.store') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="id_user">Nama</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="id_user" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="jabatan" required>
                                                @foreach ($jabatan_pimpinan as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('jabatan') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="mulai">Mulai</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="mulai"
                                                value="{{ old('mulai') }}" required>
                                            @error('selesai')
                                                <small class="text-danger">
                                                    Tanggal mulai menjabat harus lebih lama dari tanggal selesai
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="selesai">Selesai</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="selesai"
                                                value="{{ old('selesai') }}" required>
                                            @error('selesai')
                                                <small class="text-danger">
                                                    Tanggal selesai menjabat tidak boleh lebih lama dari tanggal mulai
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/admin/master-pimpinan.js') }}"></script>
@endpush
