<div class="modal fade" id="modal-edit-timkerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-timkerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-timkerja-label">Form Tambah Tugas Tim Kerja</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form method="post" action="/ketua-tim/rencana-kinerja" enctype="multipart/form-data"
                class="needs-validation" novalidate=""> --}}
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                    <div class="form-group">
                        <label class="form-label" for="edit-uraian_tugas">Uraian Tugas</label>
                        <div class="">
                            <input type="text" id="edit-uraian_tugas" class="form-control" name="edit-uraian_tugas" required value="{{ $timKerja->uraian_tugas }}">
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-rk_ketua">Rencana Kinerja Ketua</label>
                        <div class="">
                            <input type="text" id="edit-rk_ketua" class="form-control" name="edit-rk_ketua" required
                                value="{{ $timKerja->renca_kerja_ketua }}">
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-iki_ketua">IKI Ketua</label>
                        <div class="">
                            <input type="text" id="edit-iki_ketua" class="form-control" name="edit-iki_ketua" required
                                value="{{ $timKerja->iki_ketua }}">
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="button" id="btn-edit-tim" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
