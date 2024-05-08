<div class="modal fade" id="modal-create-objek" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-objek-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-objek-label">Form Tambah Objek Pengawasan</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="create-okategori">Kategori Objek</label>
                        <div class="">
                            <select id="create-okategori" class="form-control select2" name="create-okategori" required>
                                <option value="" selected disabled>Pilih Kategori Objek</option>
                                <option value="1">Unit Kerja</option>
                                <option value="2">Satuan Kerja</option>
                                <option value="3">Wilayah</option>
                                <option value="4">Kegiatan Unit Kerja</option>
                            </select>
                            <small id="error-kategori_objek" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-objek">Objek</label>
                        <div class="">
                            <select id="create-objek" class="form-control select2" name="create-objek" disabled>
                                <option value="" selected disabled>Pilih Objek</option>
                            </select>
                            <small id="error-objek" class="text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-icon icon-left btn-primary" id="btn-submit-objek">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
