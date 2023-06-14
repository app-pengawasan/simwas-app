@extends('layouts.app')

@section('title', 'Tambah Master Anggaran')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Tambah Master Anggaran</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('pagu-anggaran.update', $paguAnggaran) }}"
                                class="needs-validation" novalidate="">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="program">Program</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="program" readonly
                                                value="{{ old('program', $paguAnggaran->masterAnggaran->program) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="tahun">Tahun</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tahun" required>
                                                <?php $year = date('Y'); ?>
                                                @for ($i = -3; $i < 5; $i++)
                                                    <option value="{{ $year + $i }}"
                                                        {{ $year + $i == old('tahun', $paguAnggaran->tahun) ? 'selected' : '' }}>
                                                        {{ $year + $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="kegiatan">Kegiatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="kegiatan" required>
                                                <?php $id_kegiatan = $paguAnggaran->masterAnggaran->id_kegiatan; ?>
                                                @foreach ($kegiatan as $k)
                                                    <option value="{{ $k->id_kegiatan }}"
                                                        {{ $k->id_kegiatan == old('kegiatan', $id_kegiatan) ? 'selected' : '' }}>
                                                        {{ $k->kegiatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Komponen</label>
                                        <div class="col-sm-10 d-flex align-items-center">
                                            @foreach ($komponen as $key => $value)
                                                <div class="form-check form-check-inline mr-4">
                                                    <input class="form-check-input" type="radio" name="komponen"
                                                        id="{{ $key }}" value="{{ $key }}"
                                                        {{ old('komponen', $paguAnggaran->komponen) == $key ? 'checked="checked"' : '' }}
                                                        required>
                                                    <Label class="form-check-label"
                                                        for="{{ $key }}">{{ $key . ' ' . $value }}</Label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="akun">Akun</label>
                                        <div class="col-sm-10">
                                            <select type="text" class="form-control" name="akun" required>
                                                @foreach ($akun as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('akun', $paguAnggaran->akun) == $key ? 'selected' : '' }}>
                                                        {{ $key . ' ' . $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="uraian">Uraian</label>
                                        <div class="col-sm-10">
                                            <textarea name="uraian" id="uraian" rows="10" class="form-control form-control-md">{{ old('uraian', $paguAnggaran->uraian) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="volume">Volume</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="volume" id="volume" class="form-control"
                                                value="{{ old('volume', $paguAnggaran->volume) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="satuan">Satuan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="satuan" required>
                                                @foreach ($satuan as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('satuan', $paguAnggaran->satuan) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="harga_satuan">Harga Satuan</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="harga_satuan" id="harga_satuan"
                                                class="form-control rupiah"
                                                value="{{ old('harga_satuan', $paguAnggaran->harga) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="pagu">Pagu Anggaran</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="pagu" id="pagu" class="form-control rupiah"
                                                value="{{ old('pagu', $paguAnggaran->pagu) }}" readonly>
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
    {{-- <script src="{{ asset('js') }}/page/pagu-anggaran.js"></script> --}}
    <script>
        let volume = document.getElementById("volume");
        let harga = document.getElementById("harga_satuan");
        let pagu = document.getElementById("pagu");

        let harga_number = Number(harga.value.replace(/[^,\d]/g, ""));
        let volume_number = Number(volume.value);
        let pagu_number = harga_number * volume_number;

        harga.value = formatRupiah(harga_number.toString(), "Rp. ");
        pagu.value = formatRupiah(pagu_number.toString(), "Rp. ");

        volume.addEventListener("keyup", function(e) {
            if (Number(this.value) < 0) {
                return volume.value = "";
            }
            if (Number(this.value) > 0) {
                let harga_number = Number(harga.value.replace(/[^,\d]/g, ""));
                let volume_number = Number(volume.value);
                let pagu_number = harga_number * volume_number;

                return pagu.value = formatRupiah(pagu_number.toString(), "Rp. ");
            }
        });

        harga.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            harga.value = formatRupiah(this.value, "Rp. ");

            let harga_number = Number(harga.value.replace(/[^,\d]/g, ""));
            let volume_number = Number(volume.value);
            let pagu_number = harga_number * volume_number;

            return pagu.value = formatRupiah(pagu_number.toString(), "Rp. ");
        });


        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                harga = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                harga += separator + ribuan.join(".");
            }

            harga = split[1] != undefined ? harga + "," + split[1] : harga;
            return prefix == undefined ? harga : harga ? "Rp. " + harga : "";
        }
    </script>
@endpush
