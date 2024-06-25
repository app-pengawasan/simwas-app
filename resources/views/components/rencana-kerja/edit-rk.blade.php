<div class="modal fade" id="modal-edit-tugas" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-edit-tugas-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-tugas-label">Form Tambah Tugas Tim Kerja</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form method="post" action="/ketua-tim/rencana-kinerja" enctype="multipart/form-data"
                class="needs-validation" novalidate=""> --}}
            <form enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="edit-id_tugas" id="edit-id_tugas">
                    <div class="form-group">
                        <label class="form-label" for="edit-proyek">Proyek</label>
                        <select class="form-control select2" name="edit-proyek" id="edit-proyek" required>
                            <option value="" selected disabled>Pilih Proyek</option>
                            @foreach ($proyeks as $proyek)
                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                            @endforeach
                        </select>
                        <small id="error-edit-proyek" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit-tugas">Nama Tugas</label>
                        <div class="">
                            <input placeholder="Masukkan Nama Tugas" type="text" id="edit-tugas" class="form-control"
                                name="edit-tugas" required>
                            <small id="error-edit-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label
                            " for="edit-hasil_kerja">Hasil Kerja</label>
                        <div class="">
                            <select disabled class="form-control select2" name="edit-hasil_kerja" id="edit-hasil_kerja"
                                required>
                                <option value="" selected disabled>Pilih Hasil Kerja</option>
                                @foreach ($masterHasil as $hasil_kerja)
                                <option value="{{ $hasil_kerja->id }}">{{ $hasil_kerja->nama_hasil_kerja }}</option>
                                @endforeach
                            </select>
                            <small id="error-edit-hasil_kerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-unsur">Unsur</label>
                        <div class="">
                            <input disabled type="text" id="edit-unsur" class="form-control" name="edit-unsur" required>
                            <small id="error-edit-unsur" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-subunsur">Subunsur</label>
                        <div class="">
                            <input disabled type="text" id="edit-subunsur" class="form-control" name="edit-subunsur" required>
                            <small id="error-edit-subunsur" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-pelaksana-tugas">Pelaksana Tugas</label>
                        <div class="">
                            <input disabled type="text" id="edit-pelaksana-tugas" class="form-control" name="edit-pelaksana-tugas"
                                required>
                            <small id="error-edit-pelaksana_tugas" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" id="btn-edit-tugas" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
