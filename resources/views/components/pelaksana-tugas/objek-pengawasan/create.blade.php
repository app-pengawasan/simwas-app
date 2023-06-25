<div class="modal fade" id="modal-create-objek" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-objek-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-objek-label">Form Tambah Objek Pengawasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="create-okategori">Kategori Objek</label>
                        <div class="col-sm-10">
                            <select id="create-okategori" class="form-control" name="create-okategori" required>
                                <option value="" selected disabled></option>
                                <option value="1">Unit Kerja</option>
                                <option value="2">Satuan Kerja</option>
                                <option value="3">Wilayah</option>
                                <option value="4">Kegiatan Unit Kerja</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="create-objek">Objek</label>
                        <div class="col-sm-10">
                            <select id="create-objek" class="form-control" name="create-objek">
                                <option value="" selected disabled></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" id="btn-submit-objek">Tambah</button>
            </div>
        </div>
    </div>
</div>
