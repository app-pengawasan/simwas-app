<div class="modal fade" id="modal-create-judul-changelogs" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-judul-changelogs-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-judul-changelogs-label">Form Tambah Versi Perubahan</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="judul">Judul Perubahan</label>
                        <div class="">
                            <input type="text" id="create-judul" class="form-control" name="judul"
                                required>
                            <small id="error-judul" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="versi">Versi</label>
                        <div class="">
                            <input type="text" id="create-versi" class="form-control" name="versi" required>
                            Versi terakhir: <?php echo $versi ?>
                            <small id="error-versi" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tgl_changelog">Tanggal</label>
                        <div class="">
                            <input type="date" id="create-tgl_changelog" class="form-control" name="tgl_changelog" required>
                            <small id="error-tgl_changelog" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="keterangan">Keterangan</label>
                        <div class="">
                            <input type="text" id="create-keterangan" class="form-control" name="keterangan" required>
                            <small id="error-keterangan" class="text-danger"></small>
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
