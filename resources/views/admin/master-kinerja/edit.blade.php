<div class="modal fade" id="modal-edit-master-kinerja" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-edit-master-kinerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-master-kinerja-label">Form Tambah Hasil Kerja Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  enctype="multipart/form-data" id="form-edit-master-kinerja"
                class="needs-validation" novalidate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="editHasilKerjaID">Hasil Kerja</label>
                        <div class="">
                            <select class="form-control select2" name="editHasilKerjaID" id="editHasilKerjaID" required
                                data-placeholder="Pilih Hasil Kerja">
                                <option value=""></option>
                                @foreach ($hasilKerjaAll as $hasilKerjaAll)
                                <option value="{{ $hasilKerjaAll->id }}">{{ $hasilKerjaAll->nama_hasil_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="error-edit-hasil-kerja" class="text-danger"></small>
                    </div>
                    <input type="hidden" name="status" id="edit-status">
                    <div id="edit-gugus-tugas">
                        @php
                        $roles = [
                        'pengendaliTeknis' => 'Pengendali Teknis',
                        'ketuaTim' => 'Ketua Tim',
                        ];
                        @endphp

                        @foreach ($roles as $role => $roleName)
                        <div class="h5 text-dark d-flex align-items-center py-2"
                            style="border-bottom: 1px solid #818181">
                            <div class="badge alert-primary mr-2" style="width: 25px; height: 25px">
                                <i class="fa-solid fa-user fa-xs"></i>
                            </div>
                            <h1 class="h6 mb-0 text-bold text-dark">{{ $roleName }}</h1>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editHasilKerja_{{ $role }}">Hasil Kerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editHasilKerja_{{ $role }}"
                                    id="editHasilKerja_{{ $role }}" required placeholder="Masukkan Hasil Kerja">
                                <small id="error-hasil-kerja-pegawai_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editRencanaKinerja_{{ $role }}">Rencana Kinerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editRencanaKinerja_{{ $role }}"
                                    id="editRencanaKinerja_{{ $role }}" required placeholder="Masukkan Rencana Kinerja">
                                <small id="error-rencana-kinerja_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editIki_{{ $role }}">Indikator Kinerja Individu</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editIki_{{ $role }}"
                                    id="editIki_{{ $role }}" required placeholder="Masukkan Indikator Kinerja Individu">
                                <small id="error-editIki_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editKegiatan_{{ $role }}">Kegiatan</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editKegiatan_{{ $role }}"
                                    id="editKegiatan_{{ $role }}" required placeholder="Masukkan Kegiatan">
                                <small id="error-editKegiatan_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editCapaian_{{ $role }}">Capaian</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editCapaian_{{ $role }}"
                                    id="editCapaian_{{ $role }}" required placeholder="Masukkan Capaian">
                                <small id="error-editCapaian_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="edit-non-gugus-tugas">

                        @php
                        $roles = [
                        'penanggungJawabKegiatan' => 'Penanggung Jawab Kegiatan',
                        'PIC' => 'Person In Charge / PIC',
                        ];
                        @endphp

                        @foreach ($roles as $role => $roleName)
                        <div class="h5 text-dark d-flex align-items-center py-2"
                            style="border-bottom: 1px solid #818181">
                            <div class="badge alert-primary mr-2" style="width: 25px; height: 25px">
                                <i class="fa-solid fa-user fa-xs"></i>
                            </div>
                            <h1 class="h6 mb-0 text-bold text-dark">{{ $roleName }}</h1>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editHasilKerja_{{ $role }}">Hasil Kerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editHasilKerja_{{ $role }}"
                                    id="editHasilKerja_{{ $role }}" required placeholder="Masukkan Hasil Kerja">
                                <small id="error-hasil-kerja-pegawai_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editRencanaKinerja_{{ $role }}">Rencana Kinerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editRencanaKinerja_{{ $role }}"
                                    id="editRencanaKinerja_{{ $role }}" required placeholder="Masukkan Rencana Kinerja">
                                <small id="error-rencana-kinerja_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editIki_{{ $role }}">Indikator Kinerja Individu</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editIki_{{ $role }}"
                                    id="editIki_{{ $role }}" required placeholder="Masukkan Indikator Kinerja Individu">
                                <small id="error-editIki_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editKegiatan_{{ $role }}">Kegiatan</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editKegiatan_{{ $role }}"
                                    id="editKegiatan_{{ $role }}" required placeholder="Masukkan Kegiatan">
                                <small id="error-editKegiatan_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="editCapaian_{{ $role }}">Capaian</label>
                            <div class="">
                                <input required type="text" class="form-control" name="editCapaian_{{ $role }}"
                                    id="editCapaian_{{ $role }}" required placeholder="Masukkan Capaian">
                                <small id="error-editCapaian_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @php
                    $roles = [
                    'anggotaTim' => 'Anggota Tim',
                    ];
                    @endphp

                    @foreach ($roles as $role => $roleName)
                    <div class="h5 text-dark d-flex align-items-center py-2" style="border-bottom: 1px solid #818181">
                        <div class="badge alert-primary mr-2" style="width: 25px; height: 25px">
                            <i class="fa-solid fa-user fa-xs"></i>
                        </div>
                        <h1 class="h6 mb-0 text-bold text-dark">{{ $roleName }}</h1>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="editHasilKerja_{{ $role }}">Hasil Kerja</label>
                        <div class="">
                            <input required type="text" class="form-control" name="editHasilKerja_{{ $role }}"
                                id="editHasilKerja_{{ $role }}" required placeholder="Masukkan Hasil Kerja">
                            <small id="error-hasil-kerja-pegawai_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="editRencanaKinerja_{{ $role }}">Rencana Kinerja</label>
                        <div class="">
                            <input required type="text" class="form-control" name="editRencanaKinerja_{{ $role }}"
                                id="editRencanaKinerja_{{ $role }}" required placeholder="Masukkan Rencana Kinerja">
                            <small id="error-rencana-kinerja_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="editIki_{{ $role }}">Indikator Kinerja Individu</label>
                        <div class="">
                            <input required type="text" class="form-control" name="editIki_{{ $role }}" id="editIki_{{ $role }}"
                                required placeholder="Masukkan Indikator Kinerja Individu">
                            <small id="error-editIki_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="editKegiatan_{{ $role }}">Kegiatan</label>
                        <div class="">
                            <input required type="text" class="form-control" name="editKegiatan_{{ $role }}"
                                id="editKegiatan_{{ $role }}" required placeholder="Masukkan Kegiatan">
                            <small id="error-editKegiatan_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="editCapaian_{{ $role }}">Capaian</label>
                        <div class="">
                            <input required type="text" class="form-control" name="editCapaian_{{ $role }}"
                                id="editCapaian_{{ $role }}" required placeholder="Masukkan Capaian">
                            <small id="error-editCapaian_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button id="submit-edit-button" type="submit" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
