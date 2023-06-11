<div class="modal fade" id="modal-edit-masterhasil" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-masterhasil-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-masterhasil-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id_master_hasil" name="edit-id_master_hasil">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-unsur">Unsur</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-unsur" id="edit-unsur" required>
                            <option value="" selected disabled>Pilih Unsur</option>
                            @foreach ($unsur as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            <option value="" disabled></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-subunsur1">Subunsur 1</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-subunsur1" class="form-control" name="edit-subunsur1" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-subunsur2">Subunsur 2</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-subunsur2" class="form-control" name="edit-subunsur2" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-kategori_hasilkerja">Hasil Kerja</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-kategori_hasilkerja" id="edit-kategori_hasilkerja"
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
                    <label class="col-sm-2 col-form-label" for="edit-kategori_pelaksana">Pelaksana Tugas</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-kategori_pelaksana" id="edit-kategori_pelaksana"
                            required>
                            <option value="" selected disabled>Pilih Ketgori Pelaksana Tugas</option>
                            @foreach ($pelaksanaTugas as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                            <option value="" disabled></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" id="btn-edit-submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
