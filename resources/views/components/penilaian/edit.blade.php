<div class="modal fade" id="modal-edit-nilai" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-edit-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 33%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-nilai-label">Edit Nilai</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" name="myeditform" id="myeditform">
                <div class="modal-body">
                    <input type="hidden" name="edit-id" id="edit-id">
                    <input type="hidden" name="edit-id-pegawai" id="edit-id-pegawai">
                    <input type="hidden" name="edit-bulan" id="edit-bulan">
                    <div class="form-group form-inline">
                        <label for="edit-nilai" class="form-label col-lg-4 justify-content-start font-weight-bold">Nilai</label>
                        <input type="number" id="edit-nilai" name="edit-nilai" min="0" max="100" step=".01" class="form-control" required>
                        <small id="error-edit-nilai" class="text-danger"></small>
                    </div>    
                    <div class="form-group form-inline align-top">
                        <label class="form-label col-lg-4 justify-content-start font-weight-bold" for="edit-catatan">Catatan</label>
                        <textarea rows="5" class="form-control h-auto" id="edit-catatan" name="edit-catatan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-edit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
