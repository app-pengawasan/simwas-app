<div class="modal fade" id="modal-create-timkerja" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-create-timkerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-timkerja-label">Form Tambah Tim Kerja</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="create-tahun">Tahun</label>
                        <div class="">
                            <select class="form-control select2" id="create-tahun" name="create-tahun" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -3; $i < 5; $i++) <option value="{{ $year + $i }}"
                                    {{ $i === 0 ? 'selected' : '' }}>
                                    {{ $year + $i }}</option>
                                    @endfor
                            </select>
                            <small id="error-tahun" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-unitkerja">Unit Kerja</label>
                        <div class="">
                            <select class="form-control select2" id="create-unitkerja" name="create-unitkerja" required>
                                <option value="" disabled selected>Pilih Unit Kerja</option>
                                @foreach ($unitKerja as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                            <small id="error-unitkerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-nama">Nama Tim</label>
                        <div class="">
                            <input type="text" class="form-control" id="create-nama" name="create-nama" required placeholder="Masukkan Nama Tim Kerja">
                            <small id="error-nama" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-ketua">Ketua Tim Kerja</label>
                        <div class="">
                            <select class="form-control select2" name="create-ketua" id="create-ketua" required>
                                <option value="" selected disabled>Pilih Ketua Tim</option>
                                @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <small id="error-ketua" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-operator">Operator Tim</label>
                        {{-- optional text --}}
                        <small class="text-muted">*Optional</small>

                        <div class="">
                            <select class="form-control select2" name="create-operator" id="create-operator">
                                <option value="" selected disabled>Pilih Operator Tim</option>
                                @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <small id="error-ketua" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-iku">IKU</label>
                        <div class="">
                            <select class="form-control select2" name="create-iku" id="create-iku" required>
                                <option value="" selected disabled>Pilih IKU</option>
                                @foreach ($masterIku as $iku)
                                <option value="{{ $iku->id_iku }}" data-idsasaran="{{ $iku->id_sasaran }}">
                                    {{ $iku->iku }}</option>
                                @endforeach
                            </select>
                            <small id="error-iku" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-id_tujuan">Tujuan</label>
                        <div class="">
                            <select class="form-control" name="create-id_tujuan" id="create-id_tujuan" disabled
                                required>
                                <option value="" selected disabled></option>
                                @foreach ($masterTujuan as $tujuan)
                                <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                    data-selesai="{{ $tujuan->tahun_selesai }}">{{ $tujuan->tujuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-id_sasaran">Sasaran</label>
                        <div class="">
                            <select class="form-control" name="create-id_sasaran" id="create-id_sasaran" disabled
                                required>
                                <option value="" selected disabled></option>
                                @foreach ($masterSasaran as $sasaran)
                                <option value="{{ $sasaran->id_sasaran }}" data-idtujuan="{{ $sasaran->id_tujuan }}">
                                    {{ $sasaran->sasaran }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
