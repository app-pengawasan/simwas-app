<div class="modal fade" id="modal-create-nilai" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-nilai-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 33%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-nilai-label">Tambah Nilai</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="needs-validation" novalidate="" name="myform" id="myform">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group form-inline">
                        <label for="nilai" class="form-label col-lg-4 justify-content-start font-weight-bold">Nilai</label>
                        <input type="number" id="nilai" name="nilai" min="0" max="100" step=".01" class="form-control" required>
                        <small id="error-nilai" class="text-danger"></small>
                    </div>    
                    <div class="form-group form-inline align-top">
                        <label class="form-label col-lg-4 justify-content-start font-weight-bold" for="catatan">Catatan</label>
                        <textarea rows="5" class="form-control h-auto" id="catatan" name="catatan"></textarea>
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
