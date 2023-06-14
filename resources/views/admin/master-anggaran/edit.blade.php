@extends('layouts.app')

@section('title', 'Edit Master Anggaran')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Edit Master Anggaran</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('master-anggaran.update', $masterAnggaran) }}"
                                class="needs-validation" novalidate="">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="program">Program</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="program" disabled
                                                value="{{ old('program', $masterAnggaran->program) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="id_kegiatan">Id Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="id_kegiatan"
                                                value="{{ old('id_kegiatan', $masterAnggaran->id_kegiatan) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="kegiatan">Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="kegiatan"
                                                value="{{ old('kegiatan', $masterAnggaran->kegiatan) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Submit</button>
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

    <!-- Page Specific JS File -->
@endpush
