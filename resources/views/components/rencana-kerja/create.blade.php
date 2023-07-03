<div class="modal fade" id="modal-create-tugas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tugas-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tugas-label">Form Tambah Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/ketua-tim/rencana-kinerja" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tugas">Nama Tugas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tugas" value="{{ old('nama') }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="mulai">Waktu Mulai</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" name="mulai" value="{{ old('mulai') }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="selesai">Waktu Selesai</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" name="selesai" value="{{ old('selesai') }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_hasilkerja">Unsur</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_hasilkerja" id="id_hasilkerja" required>
                                <option value="" selected disabled>Pilih Unsur</option>
                                @foreach ($masterHasil as $hasil)
                                    <option value="{{ $hasil->id_master_hasil }}">
                                        {{ $unsur[$hasil->unsur] }}
                                    </option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="subunsur1">Subunsur 1</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="subunsur1" name="subunsur1" readonly
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="subunsur2">Subunsur 2</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="subunsur2" name="subunsur2" readonly
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kategori_hasilkerja">Hasil Kerja</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategori_hasilkerja" id="kategori_hasilkerja" disabled
                                required>
                                <option value="" selected disabled>Pilih Hasil Kerja</option>
                                @foreach ($hasilKerja as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kategori_pelaksana">Pelaksana Tugas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategori_pelaksana" id="kategori_pelaksana" disabled
                                required>
                                <option value="" selected disabled>Pilih Ketgori Pelaksana Tugas</option>
                                @foreach ($pelaksanaTugas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tahun">Tahun</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tahun" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -3; $i < 5; $i++)
                                    <option value="{{ $year + $i }}" {{ $i === old('tahun', 0) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="unitkerja">Unit Kerja</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="unitkerja" required>
                                <option value="" disabled selected>Pilih Unit Kerja</option>
                                @foreach ($unitKerja as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_tujuan">Tujuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_tujuan" id="id_tujuan" disabled required>
                                <option value="" selected disabled></option>
                                @foreach ($masterTujuan as $tujuan)
                                    <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                        data-selesai="{{ $tujuan->tahun_selesai }}">{{ $tujuan->tujuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_sasaran">Sasaran</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_sasaran" id="id_sasaran" disabled required>
                                <option value="" selected disabled></option>
                                @foreach ($masterSasaran as $sasaran)
                                    <option value="{{ $sasaran->id_sasaran }}"
                                        data-idtujuan="{{ $sasaran->id_tujuan }}">{{ $sasaran->sasaran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_iku">IKU</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_iku" id="id_iku" required>
                                <option value="" selected disabled>Pilih IKU</option>
                                @foreach ($masterIku as $iku)
                                    <option value="{{ $iku->id_iku }}" data-idsasaran="{{ $iku->id_sasaran }}">
                                        {{ $iku->iku }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="nama">Nama Tim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_ketua">Ketua Tim Kerja</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_ketua" id="id_ketua" required>
                                <option value="" selected disabled>Pilih Ketua Tim</option>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="iku">IKU</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="iku" required>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tahun_selesai">Tahun Selesai</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tahun_selesai" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -1; $i < 12; $i++)
                                    <option value="{{ $year + $i }}" {{ $i === old('tahun', 4) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tujuan">Tujuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tujuan" value="{{ old('nama') }}"
                                required>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
