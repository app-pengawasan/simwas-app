<div class="modal fade" id="modal-create-mastertujuan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-mastertujuan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-mastertujuan-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="tahun_mulai">Tahun Mulai</label>
                        <div class="">
                            <select class="form-control" id="create-tahun_mulai" name="tahun_mulai" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -5; $i < 8; $i++)
                                    <option value="{{ $year + $i }}" {{ $i === old('tahun', 0) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                @endfor
                            </select>
                            <small id="error-tahun_mulai" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tahun_selesai">Tahun Selesai</label>
                        <div class="">
                            <select class="form-control" id="create-tahun_selesai" name="tahun_selesai" required>
                                <?php $year = date('Y'); ?>
                                @for ($i = -1; $i < 12; $i++)
                                    <option value="{{ $year + $i }}" {{ $i === old('tahun', 4) ? 'selected' : '' }}>
                                        {{ $year + $i }}</option>
                                @endfor
                            </select>
                            <small id="error-tahun_selesai" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tujuan">Tujuan</label>
                        <div class="">
                            <input type="text" class="form-control" id="create-tujuan" name="tujuan"
                                value="{{ old('nama') }}" required>
                            <small id="error-tujuan" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
