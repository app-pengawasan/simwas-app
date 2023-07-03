<div class="modal fade" id="modal-create-anggaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-anggaran-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-anggaran-label">Form Tambah Anggaran</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="uraian">Uraian</label>
                        <div class="">
                            <input type="text" class="form-control" name="uraian" id="uraian" required>
                            <small id="error-uraian" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="volume">Volume</label>
                        <div class="">
                            <input type="text" class="form-control" id="volume" name="volume">
                            <small id="error-volume" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="satuan">Satuan</label>
                        <div class="">
                            <select class="form-control" name="satuan" id="satuan" required>
                                @foreach ($satuan as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-satuan" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="harga_satuan">Harga Satuan</label>
                        <div class="">
                            <input type="text" name="harga_satuan" id="harga_satuan" class="form-control" required>
                            <small id="error-harga" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="total">Total</label>
                        <div class="">
                            <input type="text" name="total" id="total" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer"></div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary" id="btn-submit-anggaran">
                    <i class="fas fa-save"></i> Tambah
                </button>
            </div>
        </div>
    </div>
</div>
