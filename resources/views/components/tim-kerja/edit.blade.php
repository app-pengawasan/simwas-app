{{-- <div class="modal fade" id="modal-edit-mastertujuan" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                <div class="form-group row">
                    <input type="hidden" id="edit-id_tujuan" name="id_tujuan">
                    <label class="col-sm-2 col-form-label" for="tahun_mulai">Tahun Mulai</label>
                    <div class="col-sm-10">
                        <select id="edit-tahun_mulai" class="form-control" name="tahun_mulai" required>
                            <?php $year = date('Y'); ?>
                            @for ($i = -5; $i < 8; $i++)
                                <option value="{{ $year + $i }}" {{ $i === old('tahun', 0) ? 'selected' : '' }}>
                                    {{ $year + $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="tahun_selesai">Tahun Selesai</label>
                    <div class="col-sm-10">
                        <select id="edit-tahun_selesai" class="form-control" name="tahun_selesai" required>
                            <?php $year = date('Y'); ?>
                            @for ($i = -1; $i < 12; $i++)
                                <option value="{{ $year + $i }}" {{ $i === old('tahun', 4) ? 'selected' : '' }}>
                                    {{ $year + $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="tujuan">Tujuan</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-tujuan" class="form-control" name="tujuan"
                            value="{{ old('nama') }}" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" id="btn-edit-submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div> --}}
