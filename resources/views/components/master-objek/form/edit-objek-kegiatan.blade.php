<div class="modal fade" id="modal-edit-objekkegiatan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-objekkegiatan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-objekkegiatan-label">Form Edit Objek Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-nama_unitkerja" name="nama_unitkerja">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="kode_unitkerja">Kegiatan</label>
                    <div class="col-sm-10">
                        <select id="edit-kode_unitkerja" class="form-control" name="kode_unitkerja" required>
                            <option value="" disabled selected>Pilih Unit Kerja</option>
                            @foreach ($master_unitkerja as $unitkerja)
                                <option value="{{ $unitkerja->kode_unitkerja }}"
                                    {{ $unitkerja->kode_unitkerja == old('kode_unitkerja') ? 'selected' : '' }}>
                                    {{ $unitkerja->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="kode_kegiatan">Kode Kegiatan</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-kode_kegiatan" class="form-control" name="kode_kegiatan" required
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" id="edit-nama" class="form-control" name="nama" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                <button type="submit" id="btn-edit-submit" class="btn btn-success">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
