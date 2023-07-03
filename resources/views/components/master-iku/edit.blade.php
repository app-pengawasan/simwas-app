<div class="modal fade" id="modal-edit-masteriku" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-masteriku-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-masteriku-label">Form Edit IKU Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id_iku" name="edit-id_iku">
                <div class="form-group">
                    <label class="form-label" for="edit-tujuan">Tujuan</label>
                    <div class="">
                        <select class="form-control" name="edit-tujuan" id="edit-tujuan" disabled required>
                            <option value="" selected disabled></option>
                            @foreach ($masterTujuan as $tujuan)
                                <?php $text = '[' . $tujuan->tahun_mulai . ' - ' . $tujuan->tahun_selesai . '] ' . $tujuan->tujuan; ?>
                                <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                    data-selesai="{{ $tujuan->tahun_selesai }}">{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit-sasaran">Sasaran</label>
                    <div class="">
                        <select class="form-control" name="edit-sasaran" id="edit-sasaran" required>
                            <option value="" selected disabled></option>
                            @foreach ($masterSasaran as $sasaran)
                                <?php $text = '[' . $sasaran->tujuan->tahun_mulai . ' - ' . $sasaran->tujuan->tahun_selesai . '] ' . $sasaran->sasaran; ?>
                                <option value="{{ $sasaran->id_sasaran }}" data-idtujuan="{{ $sasaran->id_tujuan }}">
                                    {{ $text }}</option>
                            @endforeach
                        </select>
                        <small id="error-edit-sasaran" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit-iku">IKU</label>
                    <div class="">
                        <input type="text" id="edit-iku" class="form-control" name="edit-iku" required>
                        <small id="error-edit-iku" class="text-danger"></small>
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
