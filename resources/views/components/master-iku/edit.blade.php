<div class="modal fade" id="modal-edit-masteriku" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-masteriku-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-masteriku-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id_iku" name="edit-id_iku">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-id_tujuan">Tujuan</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-id_tujuan" id="edit-id_tujuan" disabled required>
                            <option value="" selected disabled></option>
                            @foreach ($masterTujuan as $tujuan)
                                <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                    data-selesai="{{ $tujuan->tahun_selesai }}">{{ $tujuan->tujuan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-id_sasaran">Sasaran</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="edit-id_sasaran" id="edit-id_sasaran" required>
                            <option value="" selected disabled></option>
                            @foreach ($masterSasaran as $sasaran)
                                <option value="{{ $sasaran->id_sasaran }}" data-idtujuan="{{ $sasaran->id_tujuan }}">
                                    {{ $sasaran->sasaran }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="edit-iku">IKU</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-iku" class="form-control" name="edit-iku" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" id="btn-edit-submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
