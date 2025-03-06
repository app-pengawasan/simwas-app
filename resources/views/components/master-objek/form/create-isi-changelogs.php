<div class="modal fade" id="modal-create-isi-changelogs" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-isi-changelogs-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-isi-changelogs-label">Form Tambah Changelogs</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="judul">Versi</label>
                        <div class="">
                            <select class="form-control" name="id_judulchangelog" id="create-id_judulchangelog" required>
                                <?php foreach($versi as $v){ ?>
                                    <option value="<?php echo ($v->id_judulchangelog) ?>"><?php echo ($v->versi)?></option>
                                <?php } ?>
                            </select>
                            <small id="error-judul" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="isi">Isi</label>
                        <div class="">
                            <input type="text" id="create-isi" class="form-control" name="isi" required>
                            <small id="error-isi" class="text-danger"></small>
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
