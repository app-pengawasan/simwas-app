<div class="modal fade" id="modal-create-masteriku" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-masteriku-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-masteriku-label">Form Tambah IKU Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('master-iku.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="create-sasaran">Sasaran</label>
                        <div class="">
                            <select class="form-control select2" name="create-sasaran" id="create-sasaran" required data-placeholder="Pilih Sasaran Inspektorat">
                                <option value=""></option>
                                @foreach ($masterSasaran as $sasaran)
                                    <?php $text = '[' . $sasaran->tujuan->tahun_mulai . ' - ' . $sasaran->tujuan->tahun_selesai . '] ' . $sasaran->sasaran; ?>
                                    <option value="{{ $sasaran->id_sasaran }}"
                                        data-idtujuan="{{ $sasaran->id_tujuan }}">{{ $text }}</option>
                                @endforeach
                            </select>
                            <small id="error-sasaran" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-id_tujuan">Tujuan</label>
                        <div class="">
                            <select class="form-control" name="create-id_tujuan" id="create-id_tujuan" disabled required>
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
                        <label class="form-label" for="iku">IKU</label>
                        <div class="">
                            <input type="text" class="form-control" name="iku" id="create-iku" required placeholder="Masukkan Indikator Kinerja Utama">
                            <small id="error-iku" class="text-danger"></small>
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
