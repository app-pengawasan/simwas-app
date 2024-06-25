<div class="modal fade" id="modal-edit-objek" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-edit-objek-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-objek-label">Form Edit Objek Pengawasan</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit-okategori">Kategori Objek</label>
                    <div class="">
                        <select id="edit-okategori" class="form-control select2" name="edit-okategori" required>
                            <option value="" selected disabled>Pilih Kategori Objek</option>
                            <option value="1">Unit Kerja</option>
                            <option value="2">Satuan Kerja</option>
                            <option value="3">Wilayah</option>
                            <option value="4">Kegiatan Unit Kerja</option>
                        </select>
                        <small id="error-kategori_objek" class="text-danger"></small>
                    </div>
                </div>
                <input type="hidden" id="edit-id" name="edit-id">
                <div class="form-group">
                    <label class="form-label" for="edit-objek">Objek</label>
                    <div class="">
                        <select id="edit-objek" class="form-control select2" name="edit-objek" data-placeholder="Pilih Objek">
                            <option value="" selected disabled></option>
                        </select>
                        <small id="error-objek" class="text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit-nama-laporan">Nama Laporan</label>
                    <input type="text" id="edit-nama-laporan" class="form-control" name="edit-nama-laporan" required
                        placeholder="Masukkan Nama Laporan">
                    <small id="error-nama_laporan" class="text-danger"></small>
                </div>
                <div class="h5 text-dark d-flex align-items-center py-2 mb-3" style="border-bottom: 1px solid #818181">
                    <div class="badge alert-primary mr-2" style="width: 25px; height: 25px">
                        <i class="fa-solid fa-file-contract fa-xs"></i>
                    </div>
                    <h1 class="h6 mb-0 text-bold text-dark">Bulan Pelaporan Kinerja</h1>
                </div>

                <?php
                $bulan = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                    'November', 'Desember'
                ];
                ?>
                @foreach ($bulan as $key => $value)

                <div class="form-group px-2 mb-1">
                    <label class="mb-1">{{ $value }}</label>
                    <div class="d-flex align-items-center">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input name="edit-{{ $value }}" type="radio" value="1" class="selectgroup-input">
                                <span class="selectgroup-button">Ya</span>
                            </label>
                            <label class="selectgroup-item">
                                <input name="edit-{{ $value }}" type="radio" value="0" class="selectgroup-input1">
                                <span class="selectgroup-button1">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-icon icon-left btn-primary" id="btn-submit-edit-objek">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
