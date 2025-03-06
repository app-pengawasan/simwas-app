<div class="modal fade" id="modal-edit-judul-changelogs" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-judul-changelogs-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-judul-changelogs-label">Form Edit Versi Changelogs</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id_judulchangelog">
                <div class="form-group">
                    <label class="form-label" for="judul">Judul Perubahan</label>
                    <div class="">
                        <input type="text" id="edit-judul" class="form-control" name="judul"
                            required>
                        <small id="error-judul" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="versi">Versi</label>
                    <div class="">
                        <input type="text" id="edit-versi" class="form-control" name="versi" required>
                        <small id="error-versi" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <div class="">
                        <input type="text" id="edit-keterangan" class="form-control" name="keterangan" required>
                        <small id="error-keterangan" class="text-danger"></small>
                    </div>
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