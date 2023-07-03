<div class="modal fade" id="modal-edit-objek" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-objek-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-objek-label">Form Edit Objek Pengawasan</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <input type="hidden" name="id_opengawasan" id="id_opengawasan">
                        <label class="form-label" for="edit-okategori">Kategori Objek</label>
                        <div class="">
                            <select id="edit-okategori" class="form-control" name="edit-okategori" required>
                                <option value="" selected disabled></option>
                                <option value="1">Unit Kerja</option>
                                <option value="2">Satuan Kerja</option>
                                <option value="3">Wilayah</option>
                                <option value="4">Kegiatan Unit Kerja</option>
                            </select>
                            <small id="error-edit-kategori_objek" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-objek">Objek</label>
                        <div class="">
                            <select id="edit-objek" class="form-control" name="edit-objek">
                                <option value="" selected disabled></option>
                            </select>
                            <small id="error-edit-objek" class="text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-icon icon-left btn-primary" id="btn-submit-edit-objek">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
