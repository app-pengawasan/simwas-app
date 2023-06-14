<div class="modal fade" id="modal-edit-satuankerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-satuankerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-satuankerja-label">Form Edit Satuan Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-idobjek">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="kode_wilayah">Kode Wilayah</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-kode-wilayah" class="form-control" name="kode_wilayah" required>
                    </div>
                    <div class="invalid-feedback mt-2 d-none" role="alert" id="alert-kode-wilayah-edit"></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="kode_satuankerja">Kode Satuan Kerja</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-kode-satuankerja" class="form-control" name="kode_satuankerja"
                            required>
                    </div>
                    <div class="invalid-feedback mt-2 d-none" role="alert" id="alert-kode-satuan-kerja-edit"></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-nama" class="form-control" name="nama" required>
                    </div>
                    <div class="invalid-feedback mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" id="btn-edit-submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
