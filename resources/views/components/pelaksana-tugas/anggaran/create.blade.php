<div class="modal fade" id="modal-create-anggaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-anggaran-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-anggaran-label">Form Tambah Anggaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="uraian">Uraian</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="uraian" id="uraian" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="volume">Volume</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="volume" name="volume">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="satuan">Satuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="satuan" id="satuan" required>
                                @foreach ($satuan as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="harga_satuan">Harga Satuan</label>
                        <div class="col-sm-10">
                            <input type="text" name="harga_satuan" id="harga_satuan" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="total">Total</label>
                        <div class="col-sm-10">
                            <input type="text" name="total" id="total" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer"></div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" id="btn-submit-anggaran">Tambah</button>
            </div>
        </div>
    </div>
</div>
