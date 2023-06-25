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
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit-uraian">Uraian</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="edit-uraian" id="edit-uraian" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit-volume">Volume</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit-volume" name="edit-volume">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit-satuan">Satuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="edit-satuan" id="edit-satuan" required>
                                @foreach ($satuan as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit-harga_satuan">Harga Satuan</label>
                        <div class="col-sm-10">
                            <input type="text" name="edit-harga_satuan" id="edit-harga_satuan" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit-total">Total</label>
                        <div class="col-sm-10">
                            <input type="text" name="edit-total" id="edit-total" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer"></div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" id="btn-submit-edit-anggaran">Simpan</button>
            </div>
        </div>
    </div>
</div>
