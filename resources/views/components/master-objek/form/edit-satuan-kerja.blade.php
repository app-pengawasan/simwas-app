<div class="modal fade" id="modal-edit-satuankerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-satuankerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-satuankerja-label">Form Edit Satuan Kerja</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-idobjek">
                <div class="form-group">
                    <label class="form-label" for="kode_wilayah">Kode Wilayah</label>
                    <div class="">
                        <input type="text" id="edit-kode-wilayah" class="form-control" name="kode_wilayah" required>
                    </div>
                    <small id="error-edit-kode_wilayah" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="form-label" for="kode_satuankerja">Kode Satuan Kerja</label>
                    <div class="">
                        <input type="text" id="edit-kode-satuankerja" class="form-control" name="kode_satuankerja"
                            required>
                    </div>
                    <small id="error-edit-kode_satuankerja" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="form-label" for="nama">Nama</label>
                    <div class="">
                        <input type="text" id="edit-nama" class="form-control" name="nama" required>
                    </div>
                    <small id="error-edit-nama" class="text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" id="btn-edit-submit" class="btn btn-icon icon-left btn-primary">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
