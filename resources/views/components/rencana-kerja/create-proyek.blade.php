<div class="modal fade" id="modal-tambah-proyek" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-tambah-proyek-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-proyek-label">Form Tambah Proyek</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form method="post" action="/ketua-tim/rencana-kinerja" enctype="multipart/form-data"
                class="needs-validation" novalidate=""> --}}
            <form enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_timkerja" value="{{ $timKerja->id_timkerja }}">
                    <div class="form-group">
                        <label class="form-label" for="create-nama_proyek">Nama Proyek</label>
                        <div class="">
                            <input placeholder="Masukkan Nama Proyek" type="text" id="create-nama_proyek" class="form-control" name="create-nama_proyek"
                                required>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-rk_anggota">Rencana Kinerja Anggota</label>
                        <div class="">
                            <input placeholder="Masukkan Rencana Kinerja Anggota" type="text" id="create-rk_anggota" class="form-control" name="create-rk_anggota"
                                required>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="create-iki_anggota">IKI Ketua</label>
                        <div class="">
                            <input placeholder="Masukkan IKI Ketua" type="text" id="create-iki_anggota" class="form-control" name="create-iki_anggota"
                                required>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" id="btn-create-proyek" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
