<div class="modal fade" id="modal-create-tugas" data-backdrop="static" data-keyboard="false"
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
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_timkerja" id="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                    <input type="hidden" name="id_proyek" id="id_proyek">
                    <div class="form-group">
                        <label class="form-label" for="create-tugas">Proyek</label>
                        <select class="form-control select2" name="create-proyek" id="create-proyek" required disabled>
                            {{-- <option value="" selected disabled>Pilih Proyek</option> --}}
                            @foreach ($proyeks as $proyek)
                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                            @endforeach
                        </select>
                        <small id="error-proyek" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="create-tugas">Nama Tugas</label>
                        <div class="">
                            <input placeholder="Masukkan Nama Tugas" type="text" id="create-tugas" class="form-control"
                                name="create-tugas" required>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label
                            " for="create-hasil_kerja">Hasil Kerja</label>
                        <div class="">
                            <select class="form-control select2" name="create-hasil_kerja" id="create-hasil_kerja"
                                required>
                                <option value="" selected disabled>Pilih Hasil Kerja</option>
                                @foreach ($masterHasil as $hasil_kerja)
                                <option value="{{ $hasil_kerja->id }}">{{ $hasil_kerja->nama_hasil_kerja }}</option>
                                @endforeach
                            </select>
                            <small id="error-hasil_kerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="unsur">Unsur</label>
                        <div class="">
                            <input disabled type="text" id="unsur" class="form-control" name="unsur" required>
                            <small id="error-unsur" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="subunsur">Subunsur</label>
                        <div class="">
                            <input disabled type="text" id="subunsur" class="form-control" name="subunsur" required>
                            <small id="error-subunsur" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pelaksana-tugas">Pelaksana Tugas</label>
                        <div class="">
                            <input disabled type="text" id="pelaksana-tugas" class="form-control" name="pelaksana-tugas"
                                required>
                            <small id="error-pelaksana_tugas" class="text-danger"></small>
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
