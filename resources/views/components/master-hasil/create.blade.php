<div class="modal fade" id="modal-create-masterhasil" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-masterhasil-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-masterhasil-label">Form Tambah Hasil Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="create-unsur">Unsur</label>
                        <div class="">
                            <select class="form-control" name="create-unsur" id="create-unsur" required>
                                <option value="" selected disabled>Pilih Unsur</option>
                                @foreach ($unsur as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                            <small id="error-unsur" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-subunsur1">Subunsur 1</label>
                        <div class="">
                            <small class="text-primary">Jika tidak ada isi "-"</small>
                            <input type="text" class="form-control" name="create-subunsur1" id="create-subunsur1"
                                required>
                            <small id="error-subunsur1" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-subunsur2">Subunsur 2</label>
                        <div class="">
                            <small class="text-primary">Jika tidak ada isi "-"</small>
                            <input type="text" class="form-control" name="create-subunsur2" id="create-subunsur2"
                                required>
                            <small id="error-subunsur2" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-kategori_hasilkerja">Hasil Kerja</label>
                        <div class="">
                            <select class="form-control" name="create-kategori_hasilkerja"
                                id="create-kategori_hasilkerja" required>
                                <option value="" selected disabled>Pilih Hasil Kerja</option>
                                @foreach ($hasilKerja as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                            <small id="error-kategori_hasilkerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-kategori_pelaksana">Pelaksana Tugas</label>
                        <div class="">
                            <select class="form-control" name="create-kategori_pelaksana" id="create-kategori_pelaksana"
                                required>
                                <option value="" selected disabled>Pilih Ketgori Pelaksana Tugas</option>
                                @foreach ($pelaksanaTugas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                            <small id="error-kategori_pelaksana" class="text-danger"></small>
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
