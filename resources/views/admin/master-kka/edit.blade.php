<div class="modal fade" id="modal-edit-master-kka" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-master-kka-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-master-kka-label">Form Tambah KKA Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.master-kode-klasifikasi-arsip.update','link-id') }}"
                enctype="multipart/form-data" id="edit-form" class=" needs-validation" novalidate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="kode-kka">Kode Klasifikasi Arsip</label>
                        <div class="">
                            <input type="text" class="form-control" name="kode-kka" id="edit-kode-kka" required
                                placeholder="Masukkan Uraian">
                            <small id="edit-error-kode-kka" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="uraian-kka">Uraian</label>
                        <div class="">
                            <input type="text" class="form-control" name="uraian-kka" id="edit-uraian-kka" required
                                placeholder="Masukkan Uraian">
                            <small id="edit-error-uraian-kka" class="text-danger"></small>
                        </div>
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
