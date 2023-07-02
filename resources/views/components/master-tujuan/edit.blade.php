<div class="modal fade" id="modal-edit-mastertujuan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-mastertujuan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-mastertujuan-label">Form Edit Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="edit-id_tujuan" name="id_tujuan">
                    <label class="form-label" for="tahun_mulai">Tahun Mulai</label>
                    <div class="">
                        <select id="edit-tahun_mulai" class="form-control" name="tahun_mulai" required>
                            <?php $year = date('Y'); ?>
                            @for ($i = -5; $i < 8; $i++)
                                <option value="{{ $year + $i }}" {{ $i === old('tahun', 0) ? 'selected' : '' }}>
                                    {{ $year + $i }}</option>
                            @endfor
                        </select>
                        <small id="error-edit-tahun_mulai" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="tahun_selesai">Tahun Selesai</label>
                    <div class="">
                        <select id="edit-tahun_selesai" class="form-control" name="tahun_selesai" required>
                            <?php $year = date('Y'); ?>
                            @for ($i = -1; $i < 12; $i++)
                                <option value="{{ $year + $i }}" {{ $i === old('tahun', 4) ? 'selected' : '' }}>
                                    {{ $year + $i }}</option>
                            @endfor
                        </select>
                        <small id="error-edit-tahun_selesai" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="tujuan">Tujuan</label>
                    <div class="">
                        <input type="text" id="edit-tujuan" class="form-control" name="tujuan"
                            value="{{ old('nama') }}" required>
                        <small id="error-edit-tujuan" class="text-danger"></small>
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
