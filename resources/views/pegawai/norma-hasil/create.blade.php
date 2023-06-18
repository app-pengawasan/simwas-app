@extends('layouts.app')

@section('title', 'Ajukan Usulan Norma Hasil')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Usulan Norma Hasil</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/norma-hasil">Norma Hasil</a></div>
                    <div class="breadcrumb-item">Form Usulan</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                <form action="/pegawai/norma-hasil" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="status" value="0">
                                    <div class="form-group">
                                        <div class="control-label">Backdate</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="1"
                                                    class="custom-switch-input"
                                                    {{ old('is_backdate') == '1' ? 'checked' : '' }}
                                                    onchange="toggleBackdateInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_backdate') == '0' ? 'checked' : '' }}
                                                    onchange="toggleBackdateInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="tanggalInputContainer" style="display: none;" class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
                                        @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="st_kinerja_id">ST Kinerja</label>
                                        <select class="form-control select2 @error('st_kinerja_id') is-invalid @enderror" id="st_kinerja_id" name="st_kinerja_id">
                                            <option value="">Pilih st kinerja</option>
                                            @foreach ($stks as $stk)
                                                <option value="{{ $stk->id }}" {{ old('st_kinerja_id') == $stk->id ? 'selected' : '' }}>{{ $stk->no_surat }}</option>
                                            @endforeach
                                        </select>
                                        @error('st_kinerja_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="hal">Hal</label>
                                        <input type="text" class="form-control @error('hal') is-invalid @enderror" id="hal" name="hal" value="{{ old('hal') }}">
                                        @error('hal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="draft">Upload draft</label>
                                        <input type="file" class="form-control @error('draft') is-invalid @enderror" name="draft" accept=".docx, .doc" id="draft" value="{{ old('draft') }}">
                                        @error('draft')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
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
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                var tanggalInputContainer = document.getElementById('tanggalInputContainer');
                var isBackdateInput = document.querySelector('input[name="is_backdate"]:checked');
                toggleBackdateInput(isBackdateInput, tanggalInputContainer);
        });

        function toggleBackdateInput(input, tanggalInputContainer) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
        
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
            } else {
                tanggalInputContainer.style.display = 'none';
            }
        }        
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
