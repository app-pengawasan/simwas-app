@extends('layouts.app')

@section('title', 'Edit Usulan ST Pengembangan Profesi')

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
                <h1>Edit Usulan ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-pp">ST Pengembangan Profesi</a></div>
                    <div class="breadcrumb-item">Edit Usulan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $selectedPegawai = explode(', ', old('pegawai', $usulan->pegawai));
                                @endphp
                                <form action="/pegawai/st-pp/{{ $usulan->id }}" method="post">
                                    @method('PUT')
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
                                                    {{ old('is_backdate', $usulan->is_backdate) == '1' ? 'checked' : '' }}
                                                    onchange="toggleTanggalInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_backdate', $usulan->is_backdate) == '0' ? 'checked' : '' }}
                                                    onchange="toggleTanggalInput(this)">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="tanggalInputContainer" style="display: none;">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', $usulan->tanggal) }}">
                                            @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit_kerja">Unit Kerja</label>
                                        <select id="unit_kerja" name="unit_kerja" class="form-control select2 @error('unit_kerja') is-invalid @enderror">
                                            <option value="">Pilih unit kerja</option>
                                            <option value="8000" {{ old('unit_kerja', $usulan->unit_kerja) == '8000' ? 'selected' : '' }}>Inspektorat Utama</option>
                                            <option value="8010" {{ old('unit_kerja', $usulan->unit_kerja) == '8010' ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                            <option value="8100" {{ old('unit_kerja', $usulan->unit_kerja) == '8100' ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                            <option value="8200" {{ old('unit_kerja', $usulan->unit_kerja) == '8200' ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                            <option value="8300" {{ old('unit_kerja', $usulan->unit_kerja) == '8300' ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                        </select>
                                        @error('unit_kerja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pp_id">Jenis Pengembangan Profesi</label>
                                        <select class="form-control select2 @error('pp_id') is-invalid @enderror" id="pp_id" name="pp_id">
                                            <option value="">Pilih jenis pengembangan profesi</option>
                                            @foreach ($pps as $pp)
                                                <option value="{{ $pp->id }}" {{ old('pp_id', $usulan->pp_id) == $pp->id ? 'selected' : '' }}>{{ $pp->jenis }}</option>
                                            @endforeach
                                        </select>
                                        @error('pp_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="div_nama_pp">
                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="melaksanakan">Untuk melaksanakan</label>
                                        <input type="text" class="form-control @error('melaksanakan') is-invalid @enderror" id="melaksanakan" name="melaksanakan" value="{{ old('melaksanakan', $usulan->melaksanakan) }}">
                                        @error('melaksanakan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Mulai</label>
                                        <input type="date" class="form-control @error('mulai') is-invalid @enderror" name="mulai" value="{{ old('mulai', $usulan->mulai) }}">
                                        @error('mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Waktu Selesai</label>
                                        <input type="date" class="form-control @error('selesai') is-invalid @enderror" name="selesai" value="{{ old('selesai', $usulan->selesai) }}">
                                        @error('selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pegawai">Pegawai</label>
                                        <select id="pegawai" name="pegawai[]" class="form-control select2 @error('pegawai') is-invalid @enderror" multiple="multiple">
                                            <option value="">Pilih Pegawai</option>
                                            @foreach ($user as $pegawai)
                                                <option value="{{ $pegawai->id }}" {{ in_array($pegawai->id, $selectedPegawai) ? 'selected' : '' }}>{{ $pegawai->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('pegawai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="penandatangan">Penanda tangan</label>
                                        <select class="form-control select2 @error('penandatangan') is-invalid @enderror" id="penandatangan" name="penandatangan">
                                            <option value="">Pilih penanda tangan</option>
                                            <option value="0" {{ old('penandatangan', $usulan->penandatangan) == '0' ? 'selected' : '' }}>Inspektur Utama</option>
                                            <option value="1" {{ old('penandatangan', $usulan->penandatangan) == '1' ? 'selected' : '' }}>Inspektur Wilayah I</option>
                                            <option value="2" {{ old('penandatangan', $usulan->penandatangan) == '2' ? 'selected' : '' }}>Inspektur Wilayah II</option>
                                            <option value="3" {{ old('penandatangan', $usulan->penandatangan) == '3' ? 'selected' : '' }}>Inspektur Wilayah III</option>
                                            <option value="4" {{ old('penandatangan', $usulan->penandatangan) == '4' ? 'selected' : '' }}>Kepala Bagian Umum Inspektorat Utama</option>
                                        </select>
                                        @error('penandatangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="control-label">E-Sign</div>
                                        <div class="custom-switches-stacked mt-2">
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="1"
                                                    class="custom-switch-input"
                                                    {{ old('is_esign', $usulan->is_esign) == '1' ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="0"
                                                    class="custom-switch-input"
                                                    {{ old('is_esign', $usulan->is_esign) == '0' ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
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
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        function toggleTanggalInput(input) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
    
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
            } else {
                tanggalInputContainer.style.display = 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#pp_id").on("change", function() {
                const ppId = $(this).val();
                if(ppId == 1 || ppId == 2 || ppId == 3){
                    $.ajax({
                    url: `/get-nama-pp-by-pp`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        pp_id: ppId
                    },
                    dataType: "json",
                    success: (data) => {
                        $("#div_nama_pp").empty();
                        $("#div_nama_pp").append(`<label for="nama_pp">Nama Pengembangan Profesi</label>
                                        <select id="nama_pp" required class="form-control select2" name="nama_pp">
                                            <option value="">Pilih nama pengembangan profesi</option>
                                        </select>`);

                        data.namaPp.forEach(element => {
                            $("#nama_pp").append(
                                `<option value="${element.nama}">${element.nama}</option>`
                            );
                        });
                        // console.log(data);
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                    }
                });
                } else {
                    $("#div_nama_pp").empty();
                    $("#div_nama_pp").append(`<label for="nama_pp">Nama Pengembangan Profesi</label><input type="text" class="form-control" id="nama_pp_text" name="nama_pp">`);
                }
            });
        });
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
