<div class="modal fade" id="modal-create-tugas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tugas-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tugas-label">Form Tambah Tugas Tim Kerja</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form method="post" action="/ketua-tim/rencana-kinerja" enctype="multipart/form-data"
                class="needs-validation" novalidate=""> --}}
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                    <div class="form-group">
                        <label class="form-label" for="create-tugas">Nama Tugas</label>
                        <div class="">
                            <input type="text" id="create-tugas" class="form-control" name="create-tugas" required>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-mulai">Waktu Mulai</label>
                        <div class="">
                            <input type="date" id="create-mulai" class="form-control" name="create-mulai" required>
                            <small id="error-mulai" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-selesai">Waktu Selesai</label>
                        <div class="">
                            <input type="date" id="create-selesai" class="form-control" name="create-selesai"
                                required>
                            <small id="error-selesai" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-unsur">Unsur</label>
                        <div class="">
                            <select class="form-control" name="create-unsur" id="create-unsur" disabled required>
                                <option value="" selected disabled>Pilih Unsur</option>
                                @foreach ($unsur as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-subunsur1">Subunsur 1</label>
                        <div class="">
                            <input type="text" class="form-control" name="create-subunsur1" id="create-subunsur1"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="subunsur2">Subunsur 2</label>
                        <div class="">
                            <input type="text" class="form-control" name="create-subunsur2" id="create-subunsur2"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-hasilkerja">Hasil Kerja</label>
                        <div class="">
                            <select class="form-control" name="create-hasilkerja" id="create-hasilkerja" required>
                                <option value="" selected disabled>Pilih Hasil Kerja</option>
                                @foreach ($masterHasil as $hasil)
                                    <option value="{{ $hasil->id_master_hasil }}">
                                        {{ $hasilKerja[$hasil->kategori_hasilkerja] }}
                                    </option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                            <small id="error-hasilkerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-kategori_pelaksana">Pelaksana Tugas</label>
                        <div class="">
                            <select class="form-control" name="create-kategori_pelaksana" id="create-kategori_pelaksana"
                                disabled required>
                                <option value="" selected disabled>Pilih Ketgori Pelaksana Tugas</option>
                                @foreach ($pelaksanaTugas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" id="btn-tambah-tugas" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
