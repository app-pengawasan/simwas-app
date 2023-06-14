<div class="modal fade" id="modal-edit-mastersasaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-mastersasaran-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-mastersasaran-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_sasaran" id="edit-id_sasaran">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-id_tujuan">Tujuan</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-id_tujuan" id="edit-id_tujuan" required>
                            <option value="" selected disabled></option>
                            @foreach ($masterTujuan as $tujuan)
                                <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                    data-selesai="{{ $tujuan->tahun_selesai }}">{{ $tujuan->tujuan }}</option>
                            @endforeach
                        </select>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" id="btn-edit-submit">Simpan</button>
            </div>
        </div>
    </div>
</div>
