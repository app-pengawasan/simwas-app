<div class="modal fade" id="modal-create-satuankerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-satuankerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-satuankerja-label">Form Tambah Satuan Kerja</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="kode_wilayah">Kode Wilayah</label>
                        <div class="">
                            <input type="text" id="create-kode_wilayah" class="form-control" name="kode_wilayah"
                                required>
                            <small id="error-kode_wilayah" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kode_satuankerja">Kode Satuan Kerja</label>
                        <div class="">
                            <input type="text" id="create-kode_satuankerja" class="form-control"
                                name="kode_satuankerja" required>
                            <small id="error-kode_satuankerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama</label>
                        <div class="">
                            <input type="text" id="create-nama" class="form-control" name="nama" required>
                            <small id="error-nama" class="text-danger"></small>
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
