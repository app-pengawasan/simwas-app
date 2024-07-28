<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Penyelenggara Diklat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" name="myeditform" id="myeditform">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="data_id" name="data_id">
                        <label for="edit-penyelenggara" class="mt-3">Penyelenggara Diklat</label>
                        <input type="text" class="form-control" id="edit-penyelenggara" name="edit-penyelenggara" required>
                        <small id="error-edit-penyelenggara" class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="edit-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>