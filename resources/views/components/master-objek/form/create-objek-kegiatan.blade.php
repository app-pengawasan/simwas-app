<div class="modal fade" id="modal-create-objekkegiatan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-objekkegiatan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-objekkegiatan-label">Form Tambah wilayah Kerja</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <input type="hidden" id="nama_unitkerja" name="nama_unitkerja">
                    <div class="form-group">
                        <label class="form-label" for="kode_unitkerja">Kegiatan</label>
                        <div class="">
                            <select id="unit_kerja" class="form-control" name="unit_kerja" required>
                                <option value="" disabled selected>Pilih Unit Kerja</option>
                                @foreach ($master_unitkerja as $unitkerja)
                                    <option value="{{ $unitkerja->kode_unitkerja }}">
                                        {{ $unitkerja->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-unit_kerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kode_kegiatan">Kode Kegiatan</label>
                        <div class="">
                            <input type="text" id="kode_kegiatan" class="form-control" name="kode_kegiatan" required
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama</label>
                        <div class="">
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <small id="error-nama" class="text-danger"></small>
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
