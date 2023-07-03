<div class="modal fade" id="modal-import-excel" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-import-excel-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-excel-label">{{ $title_modal }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ $url_modal_import }}" enctype="multipart/form-data" class="needs-validation"
                novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx" required>
                        <div class="invalid-feedback">
                            File belum ditambahkan
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-upload"></i> Impor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
