<div class="modal fade" id="modal-edit-mastersasaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-mastersasaran-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-mastersasaran-label">Form Sasaran Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_sasaran" id="edit-id_sasaran">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-tujuan">Tujuan</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-tujuan" id="edit-tujuan" required>
                            <option value="" selected disabled></option>
                            @foreach ($masterTujuan as $tujuan)
                                <?php $text = '[' . $tujuan->tahun_mulai . '-' . $tujuan->tahun_selesai . '] ' . $tujuan->tujuan; ?>
                                <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                    data-selesai="{{ $tujuan->tahun_selesai }}">{{ $text }}</option>
                            @endforeach
                        </select>
                        <small id="error-edit-tujuan" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-tahun_mulai">Tahun Mulai</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="edit-tahun_mulai" id="edit-tahun_mulai"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-tahun_selesai">Tahun Selesai</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="edit-tahun_selesai" id="edit-tahun_selesai"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-sasaran">Sasaran</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="edit-sasaran" name="edit-sasaran" required>
                        <small id="error-edit-sasaran" class="text-danger"></small>
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
