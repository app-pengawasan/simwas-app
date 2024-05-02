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
            <h1>Form Edit Pimpinan</h1>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="row mb-4 pb-0">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="javascript(0);" id="btn-back">
                                    <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </div> --}}
                        <form method="POST" action="{{ route('master-pimpinan.update', $pimpinan) }}"
                            class="needs-validation" novalidate="">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label for="id_user">Nama</label>
                                <select class="form-control" name="id_user" disabled required>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('id_user', $pimpinan->user->id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select class="form-control" name="jabatan" required>
                                    @foreach ($jabatan_pimpinan as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('jabatan', $pimpinan->jabatan) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mulai">Mulai</label>
                                <input type="date" class="form-control" name="mulai"
                                    value="{{ old('mulai', $pimpinan->mulai) }}" required>
                                @error('selesai')
                                <small class="text-danger">
                                    Tanggal mulai menjabat harus lebih lama dari tanggal selesai
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="selesai">Selesai</label>
                                <input type="date" class="form-control" name="selesai"
                                    value="{{ old('selesai', $pimpinan->selesai) }}" required>
                                @error('selesai')
                                <small class="text-danger">
                                    Tanggal selesai menjabat tidak boleh lebih lama dari tanggal mulai
                                </small>
                                @enderror
                            </div>
                            <hr class="my-1">
                            <div class="d-flex  mt-4" style="gap:10px">
                                <a class="btn btn-outline-primary" href="javascript(0);" id="btn-back">
                                    Kembali
                                </a>
                                <button class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>
                                    Simpan
                                </button>
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