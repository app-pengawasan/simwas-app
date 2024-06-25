<div class="modal fade" id="modal-create-master-laporan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-master-laporan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-master-laporan-label">Form Tambah laporan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('admin.master-laporan.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="kode-laporan">Kode Laporan</label>
                        <div class="">
                            <input type="text" class="form-control" name="kode-laporan" id="kode-laporan" required
                                placeholder="Masukkan Kode Laporan">
                            <small id="error-kode-laporan" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama-laporan">Nama Laporan</label>
                        <div class="">
                            <input type="text" class="form-control" name="nama-laporan" id="nama-laporan" required
                                placeholder="Masukkan Nama Laporan">
                            <small id="error-nama-laporan" class="text-danger"></small>
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