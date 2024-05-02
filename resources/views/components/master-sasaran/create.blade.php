<div class="modal fade" id="modal-create-mastersasaran" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-mastersasaran-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-mastersasaran-label">Form Tambah Sasaran Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="tujuan">Tujuan</label>
                        <div class="">
                            <select class="form-control select2" name="tujuan" id="create-tujuan" required data-placeholder="Pilih Tujuan Inspektorat">
                                <option value=""></option>
                                @foreach ($masterTujuan as $tujuan)
                                    <?php $text = '[' . $tujuan->tahun_mulai . '-' . $tujuan->tahun_selesai . '] ' . $tujuan->tujuan; ?>
                                    <option value="{{ $tujuan->id_tujuan }}" data-mulai="{{ $tujuan->tahun_mulai }}"
                                        data-selesai="{{ $tujuan->tahun_selesai }}">{{ $text }}</option>
                                @endforeach
                            </select>
                            <small id="error-tujuan" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tahun_mulai">Tahun Mulai</label>
                        <div class="">
                            <input type="text" class="form-control" name="tahun_mulai" id="create-tahun_mulai"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tahun_selesai">Tahun Selesai</label>
                        <div class="">
                            <input type="text" class="form-control" name="tahun_selesai" id="create-tahun_selesai"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="sasaran">Sasaran</label>
                        <div class="">
                            <input type="text" class="form-control" name="sasaran" id="create-sasaran" required placeholder="Masukkan Sasaran Inspektorat">
                            <small id="error-sasaran" class="text-danger"></small>
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
