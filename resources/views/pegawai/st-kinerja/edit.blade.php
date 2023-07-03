@extends('layouts.app')

@section('title', 'Edit Usulan ST Kinerja')

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
                @if ($usulan->status == 1)
                <h1>Edit ST Kinerja</h1>
                @elseif ($usulan->status == 5)
                <h1>Ajukan Nomor Norma Hasil</h1>
                @endif
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/pegawai/st-kinerja">ST Kinerja</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                    <form action="/pegawai/st-kinerja/{{ $usulan->id }}" method="post">
                                        @method('PUT')
                                        @csrf
                                        @php
                                            // $selectedObjek = old('objek') ?? explode('');
                                        @endphp
                                        <input type="hidden" name="status" value="0">
                                        <div class="form-group">
                                            <label class="d-block">Backdate</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="1"
                                                    {{ old('is_backdate', $usulan->is_backdate) == '1' ? 'checked' : '' }}
                                                    onchange="toggleBackdateInput(this)"
                                                    id="is_backdate_ya"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_backdate_ya">Ya</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_backdate"
                                                    value="0"
                                                    {{ old('is_backdate', $usulan->is_backdate) == '0' ? 'checked' : '' }}
                                                    onchange="toggleBackdateInput(this)"
                                                    id="is_backdate_tidak"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_backdate_tidak">Tidak</label>
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
                                            <label for="tim_kerja">Tim Kerja</label>
                                            <input type="text" readonly class="form-control @error('tim_kerja') is-invalid @enderror" id="tim_kerja" name="tim_kerja" value="{{ old('tim_kerja') }}">
                                            @error('tim_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="rencana_id">Tugas</label>
                                            <select id="rencana_id" name="rencana_id" class="form-control select2 @error('rencana_id') is-invalid @enderror">
                                                <option value="">Pilih tugas</option>
                                                @foreach ($rencana_kerja as $rencana)
                                                    <option value="{{ $rencana->id_rencanakerja }}" {{ old('rencana_id', $usulan->rencana_id) == $rencana->id_rencanakerja ? 'selected' : '' }}>{{ $rencana->tugas }}</option>
                                                @endforeach
                                            </select>
                                            @error('rencana_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="unit_kerja1" name="unit_kerja" value="{{ old('unit_kerja') }}">
                                            <label for="unit_kerja">Unit Kerja</label>
                                            <select disabled id="unit_kerja" name="unit_kerja" class="form-control select2 @error('unit_kerja') is-invalid @enderror">
                                                <option value="">Pilih unit kerja</option>
                                                <option value="8000" {{ old('unit_kerja') == '8000'  ? 'selected' : '' }}>Inspektorat Utama</option>
                                                <option value="8010" {{ old('unit_kerja') == '8010'  ? 'selected' : '' }}>Bagian Umum Inspektorat Utama</option>
                                                <option value="8100" {{ old('unit_kerja') == '8100'  ? 'selected' : '' }}>Inspektorat Wilayah I</option>
                                                <option value="8200" {{ old('unit_kerja') == '8200'  ? 'selected' : '' }}>Inspektorat Wilayah II</option>
                                                <option value="8300" {{ old('unit_kerja') == '8300'  ? 'selected' : '' }}>Inspektorat Wilayah III</option>
                                            </select>
                                            @error('unit_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
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
                                            <input type="hidden" id="objek1" name="objek" value="{{ old('objek') }}">
                                            <label for="objek">Objek</label>
                                            <textarea readonly style="height: 200px;" type="text" class="form-control @error('objek') is-invalid @enderror" id="objek" name="objek">{{ old('objek') }}</textarea>
                                            @error('objek')
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
                                            <input type="hidden" id="pelaksana1" name="pelaksana" value="{{ old('pelaksana') }}">
                                            <label for="pelaksana">Pelaksana Tugas</label>
                                            <textarea readonly style="height: 200px;" type="text" class="form-control @error('pelaksana') is-invalid @enderror" id="pelaksana" name="pelaksana">{{ old('pelaksana') }}</textarea>
                                            @error('pelaksana')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="control-label">E-Sign</div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="1"
                                                    {{ old('is_esign', $usulan->is_esign) == '1' ? 'checked' : '' }}
                                                    onchange="toggleEsignInput(this)"
                                                    id="is_esign_ya"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_esign_ya">Ya</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio"
                                                    name="is_esign"
                                                    value="0"
                                                    {{ old('is_esign', $usulan->is_esign) == '0' ? 'checked' : '' }}
                                                    onchange="toggleEsignInput(this)"
                                                    id="is_esign_tidak"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="is_esign_tidak">Tidak</label>
                                            </div>
                                        </div>
                                        <div class="form-group"  id="penandatanganContainer" style="display: none;">
                                            <label for="penandatangan">Penanda tangan</label>
                                            <select class="form-control select2 @error('penandatangan') is-invalid @enderror" id="penandatangan" name="penandatangan">
                                                <option value="">Pilih penanda tangan</option>
                                                @foreach ($pimpinanAktif as $pimpinan)
                                                    <option value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan', $usulan->penandatangan) == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $pimpinan->jabatan }}] {{ $pimpinan->user->name }}</option>
                                                @endforeach
                                                
                                                @foreach ($pimpinanNonaktif as $pimpinan)
                                                    <option class="pimpinanNonaktif" value="{{ $pimpinan->id_pimpinan }}" {{ old('penandatangan', $usulan->penandatangan) == $pimpinan->id_pimpinan ? 'selected' : ''}}>[{{ $pimpinan->jabatan }}] {{ $pimpinan->user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('penandatangan')
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
        document.addEventListener('DOMContentLoaded', function() {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
            var pimpinanNonaktif = document.getElementsByClassName("pimpinanNonaktif");
            var isBackdateInput = document.querySelector('input[name="is_backdate"]:checked');
            toggleBackdateInput(isBackdateInput, tanggalInputContainer, pimpinanNonaktif);
            
            var penandatanganContainer = document.getElementById('penandatanganContainer');
            var isEsignInput = document.querySelector('input[name="is_esign"]:checked');
            toggleEsignInput(isEsignInput, penandatanganContainer);
        
            document.getElementById("rencana_id").addEventListener("change", function() {
                    var selectedRencanaKerja = this.value;
                    console.log(selectedRencanaKerja);
                    $.ajax({
                    url: '/tugas',
                    method: 'GET',
                    data: {
                        rencana_id: selectedRencanaKerja
                    },
                    success: function(response) {
                        console.log(response);
                        var timKerja = response.tim_kerja;
                        var objekPengawasan = response.objek_pengawasan;

                        var objek = [];
                        var counter = 0;
                        objekPengawasan.forEach(function(element) {
                        counter++;
                        objek.push(counter + ". " + element.nama);
                        });
                        var objekJoined = objek.join('\n');

                        var pelaksanaTugas = '';
                        var dalnis = response.dalnis;
                        var ketua = response.ketua;
                        var pic = response.pic;
                        var anggota = response.anggota;
                        if (dalnis !== 0) {
                        pelaksanaTugas += dalnis + '\n';
                        }
                        if (ketua !== 0) {
                        pelaksanaTugas += ketua + '\n';
                        }
                        if (pic !== 0) {
                        pelaksanaTugas += pic + '\n';
                        }
                        if (anggota !== 0) {
                        pelaksanaTugas += anggota.join('\n');
                        }

                        document.getElementById("tim_kerja").value = timKerja.nama;

                        document.getElementById("unit_kerja").value = timKerja.unitkerja;
                        $("#unit_kerja").select2("destroy");
                        $("#unit_kerja").select2();
                        document.getElementById("unit_kerja1").value = timKerja.unitkerja;

                        document.getElementById("objek").value = objekJoined;
                        document.getElementById("objek1").value = objekJoined;

                        document.getElementById("pelaksana").value = pelaksanaTugas;
                        document.getElementById("pelaksana1").value = pelaksanaTugas;
                    }
                });
            });
        });
        
        function toggleBackdateInput(input, tanggalInputContainer, pimpinanNonaktif) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
            var pimpinanNonaktif = document.getElementsByClassName("pimpinanNonaktif");
    
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
                for (var i = 0; i < pimpinanNonaktif.length; i++) {
                    pimpinanNonaktif[i].removeAttribute("disabled");
                }
            } else {
                tanggalInputContainer.style.display = 'none';
                for (var i = 0; i < pimpinanNonaktif.length; i++) {
                    pimpinanNonaktif[i].setAttribute("disabled", "disabled");
                }
            }
        }

        function toggleEsignInput(input, penandatanganContainer) {
            var penandatanganContainer = document.getElementById('penandatanganContainer');
    
            if (input.value === '1') {
                penandatanganContainer.style.display = 'block';
            } else {
                penandatanganContainer.style.display = 'none';
            }
        }
        
    </script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#rencana_id').change(function() {
                var selectedRencanaKerja = $(this).val();
                console.log(selectedRencanaKerja);
                $.ajax({
                    url: '/tugas',
                    method: 'GET',
                    data: {
                        rencana_id: selectedRencanaKerja
                    },
                    success: function(response){
                        console.log(response);
                        var timKerja = response.tim_kerja;
                        var objekPengawasan = response.objek_pengawasan;
                        
                        var objek = [];
                        var counter = 0;
                        objekPengawasan.forEach(element => {
                            counter++;
                            objek.push(counter + ". " + element.nama);
                        });
                        var objekJoined = objek.join('\n');
                        
                        var pelaksanaTugas = '';
                        var dalnis = response.dalnis;
                        var ketua = response.ketua;
                        var pic = response.pic;
                        var anggota = response.anggota;
                        if (dalnis !== 0) {
                            pelaksanaTugas += dalnis + '\n';
                        }
                        if (ketua !== 0) {
                            pelaksanaTugas += ketua + '\n';
                        }
                        if (pic !== 0) {
                            pelaksanaTugas += pic + '\n';
                        }
                        if (anggota !== 0) {
                            pelaksanaTugas += anggota.join('\n');
                        }
                        

                        $('#tim_kerja').val(timKerja.nama);

                        $('#unit_kerja').val(timKerja.unitkerja);
                        $("#unit_kerja").select2("destroy");
                        $("#unit_kerja").select2();
                        $('#unit_kerja1').val(timKerja.unitkerja);

                        $('#objek').val(objekJoined);
                        $('#objek1').val(objekJoined);

                        $('#pelaksana').val(pelaksanaTugas);
                        $('#pelaksana1').val(pelaksanaTugas);
                    }
                });
            });
        })
    </script>

    @endpush