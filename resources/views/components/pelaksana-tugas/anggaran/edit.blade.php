<div class="modal fade" id="modal-edit-anggaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-anggaran-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-anggaran-label">Form Edit Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <input type="hidden" name="id_rkanggaran" id="id_rkanggaran">
                    <div class="form-group">
                        <label class="form-label" for="edit-uraian">Uraian</label>
                        <div class="">
                            <input type="text" class="form-control" name="edit-uraian" id="edit-uraian" required>
                            <small id="error-edit-uraian" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-volume">Volume</label>
                        <div class="">
                            <input type="text" class="form-control" id="edit-volume" name="edit-volume">
                            <small id="error-edit-volume" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-satuan">Satuan</label>
                        <div class="">
                            <select class="form-control" name="edit-satuan" id="edit-satuan" required>
                                @foreach ($satuan as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-edit-satuan" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-harga_satuan">Harga Satuan</label>
                        <div class="">
                            <input type="text" name="edit-harga_satuan" id="edit-harga_satuan" class="form-control"
                                required>
                            <small id="error-edit-harga" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-total">Total</label>
                        <div class="">
                            <input type="text" name="edit-total" id="edit-total" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer"></div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary btn-icon icon-left" id="btn-submit-edit-anggaran">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
