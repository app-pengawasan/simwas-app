<div class="modal fade" id="modal-create-master-kinerja" data-backdrop="static" data-keyboard="false" 
    aria-labelledby="modal-create-master-SubUnsur-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-master-SubUnsur-label">Form Tambah Hasil Kerja Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.master-kinerja.store') }}" enctype="multipart/form-data" id="form-create-master-kinerja"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="hasilKerjaID">Hasil Kerja</label>
                        <div class="">
                            <select class="form-control select2" name="hasilKerjaID" id="hasilKerjaID" required data-placeholder="Pilih Hasil Kerja">
                                <option value=""></option>
                                @foreach ($hasilKerja as $hasilKerja)
                                <option value="{{ $hasilKerja->id }}">{{ $hasilKerja->nama_hasil_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="error-hasil-kerja" class="text-danger"></small>
                    </div>
                    <input type="hidden" name="status" id="create-status">
                    <div id="gugus-tugas">
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
                            <label class="form-label mb-1" for="hasilKerja_{{ $role }}">Hasil Kerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="hasilKerja_{{ $role }}"
                                    id="hasilKerja_{{ $role }}" required placeholder="Masukkan Hasil Kerja">
                                <small id="error-hasil-kerja-pegawai_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="rencanaKinerja_{{ $role }}">Rencana Kinerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="rencanaKinerja_{{ $role }}"
                                    id="rencanaKinerja_{{ $role }}" required placeholder="Masukkan Rencana Kinerja">
                                <small id="error-rencana-kinerja_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="iki_{{ $role }}">Indikator Kinerja Individu</label>
                            <div class="">
                                <input required type="text" class="form-control" name="iki_{{ $role }}" id="iki_{{ $role }}"
                                    required placeholder="Masukkan Indikator Kinerja Individu">
                                <small id="error-iki_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="kegiatan_{{ $role }}">Kegiatan</label>
                            <div class="">
                                <input required type="text" class="form-control" name="kegiatan_{{ $role }}"
                                    id="kegiatan_{{ $role }}" required placeholder="Masukkan Kegiatan">
                                <small id="error-kegiatan_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="capaian_{{ $role }}">Capaian</label>
                            <div class="">
                                <input required type="text" class="form-control" name="capaian_{{ $role }}"
                                    id="capaian_{{ $role }}" required placeholder="Masukkan Capaian">
                                <small id="error-capaian_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="non-gugus-tugas">

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
                            <label class="form-label mb-1" for="hasilKerja_{{ $role }}">Hasil Kerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="hasilKerja_{{ $role }}"
                                    id="hasilKerja_{{ $role }}" required placeholder="Masukkan Hasil Kerja">
                                <small id="error-hasil-kerja-pegawai_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="rencanaKinerja_{{ $role }}">Rencana Kinerja</label>
                            <div class="">
                                <input required type="text" class="form-control" name="rencanaKinerja_{{ $role }}"
                                    id="rencanaKinerja_{{ $role }}" required placeholder="Masukkan Rencana Kinerja">
                                <small id="error-rencana-kinerja_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="iki_{{ $role }}">Indikator Kinerja Individu</label>
                            <div class="">
                                <input required type="text" class="form-control" name="iki_{{ $role }}" id="iki_{{ $role }}"
                                    required placeholder="Masukkan Indikator Kinerja Individu">
                                <small id="error-iki_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="kegiatan_{{ $role }}">Kegiatan</label>
                            <div class="">
                                <input required type="text" class="form-control" name="kegiatan_{{ $role }}"
                                    id="kegiatan_{{ $role }}" required placeholder="Masukkan Kegiatan">
                                <small id="error-kegiatan_{{ $role }}" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label mb-1" for="capaian_{{ $role }}">Capaian</label>
                            <div class="">
                                <input required type="text" class="form-control" name="capaian_{{ $role }}"
                                    id="capaian_{{ $role }}" required placeholder="Masukkan Capaian">
                                <small id="error-capaian_{{ $role }}" class="text-danger"></small>
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
                        <label class="form-label mb-1" for="hasilKerja_{{ $role }}">Hasil Kerja</label>
                        <div class="">
                            <input required type="text" class="form-control" name="hasilKerja_{{ $role }}" id="hasilKerja_{{ $role }}"
                                required placeholder="Masukkan Hasil Kerja">
                            <small id="error-hasil-kerja-pegawai_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="rencanaKinerja_{{ $role }}">Rencana Kinerja</label>
                        <div class="">
                            <input required type="text" class="form-control" name="rencanaKinerja_{{ $role }}"
                                id="rencanaKinerja_{{ $role }}" required placeholder="Masukkan Rencana Kinerja">
                            <small id="error-rencana-kinerja_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="iki_{{ $role }}">Indikator Kinerja Individu</label>
                        <div class="">
                            <input required type="text" class="form-control" name="iki_{{ $role }}" id="iki_{{ $role }}" required
                                placeholder="Masukkan Indikator Kinerja Individu">
                            <small id="error-iki_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="kegiatan_{{ $role }}">Kegiatan</label>
                        <div class="">
                            <input required type="text" class="form-control" name="kegiatan_{{ $role }}" id="kegiatan_{{ $role }}" required
                                placeholder="Masukkan Kegiatan">
                            <small id="error-kegiatan_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label mb-1" for="capaian_{{ $role }}">Capaian</label>
                        <div class="">
                            <input required type="text" class="form-control" name="capaian_{{ $role }}" id="capaian_{{ $role }}" required
                                placeholder="Masukkan Capaian">
                            <small id="error-capaian_{{ $role }}" class="text-danger"></small>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button id="submit-create-btn" type="submit" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
