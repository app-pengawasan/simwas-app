<div class="modal fade" id="modal-create-pelaksana" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-create-pelaksana-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-pelaksana-label">Form Tambah Pelaksana Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label class="label" for="pt-jabatan">Peran</label>
                        <div class="">
                            <select id="pt-jabatan" class="form-control" name="pt-jabatan" disabled required>
                                <option value="1">Pengendali Teknis</option>
                                <option value="2">Ketua Tim</option>
                                <option value="3">PIC</option>
                                <option value="4">Anggota Tim</option>
                                <option value="5">Penanggung Jawab Kegiatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label" for="pelaksana">Nama</label>
                        <div class="">
                            <select id="pelaksana" class="form-control select2" name="pelaksana">
                                <option value="" selected disabled></option>
                                @foreach ($pegawai as $p)
                                    <?php
                                    $key = array_search($p->id, array_column($rencanaKerja->pelaksana->toArray(), 'id_pegawai'));
                                    ?>
                                    @if ($key === false)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small id="error-pelaksana" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-weight: 600px;">Kebutuhan Jam Kerja Per Bulan</label>
                        <div id="month-wrap">
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-januari">Januari</label>
                                <input type="text" id="create-januari" class="form-control jam-kerja" name="create-januari" required
                                    style="min-width: 60px;">
                                <small id="error-januari" class="text-danger"></small>
                            </div>
                            {{-- februari --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-februari">Februari</label>
                                <input type="text" id="create-februari" class="form-control jam-kerja" name="create-februari" required
                                    style="min-width: 60px;">
                                <small id="error-februari" class="text-danger"></small>
                            </div>
                            {{-- maret --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-maret">Maret</label>
                                <input type="text" id="create-maret" class="form-control jam-kerja" name="create-maret" required
                                    style="min-width: 60px;">
                                <small id="error-maret" class="text-danger"></small>
                            </div>
                            {{-- april --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-april">April</label>
                                <input type="text" id="create-april" class="form-control jam-kerja" name="create-april" required
                                    style="min-width: 60px;">
                                <small id="error-april" class="text-danger"></small>
                            </div>
                            {{-- mei --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-mei">Mei</label>
                                <input type="text" id="create-mei" class="form-control jam-kerja" name="create-mei" required style="min-width: 60px;">
                                <small id="error-mei" class="text-danger"></small>
                            </div>
                            {{-- juni --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-juni">Juni</label>
                                <input type="text" id="create-juni" class="form-control jam-kerja" name="create-juni" required
                                    style="min-width: 60px;">
                                <small id="error-juni" class="text-danger"></small>
                            </div>
                            {{-- juli --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-juli">Juli</label>
                                <input type="text" id="create-juli" class="form-control jam-kerja" name="create-juli" required
                                    style="min-width: 60px;">
                                <small id="error-juli" class="text-danger"></small>
                            </div>
                            {{-- agustus --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-agustus">Agustus</label>
                                <input type="text" id="create-agustus" class="form-control jam-kerja" name="create-agustus" required
                                    style="min-width: 60px;">
                                <small id="error-agustus" class="text-danger"></small>
                            </div>
                            {{-- september --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-september">September</label>
                                <input type="text" id="create-september" class="form-control jam-kerja" name="create-september" required
                                    style="min-width: 60px;">
                                <small id="error-september" class="text-danger"></small>
                            </div>
                            {{-- oktober --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-oktober">Oktober</label>
                                <input type="text" id="create-oktober" class="form-control jam-kerja" name="create-oktober" required
                                    style="min-width: 60px;">
                                <small id="error-oktober" class="text-danger"></small>
                            </div>
                            {{-- november --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-november">November</label>
                                <input type="text" id="create-november" class="form-control jam-kerja" name="create-november" required
                                    style="min-width: 60px;">
                                <small id="error-november" class="text-danger"></small>
                            </div>
                            {{-- desember --}}
                            <div class="d-flex flex-column">
                                <label class="form-label
                                                    " for="create-desember">Desember</label>
                                <input type="text" id="create-desember" class="form-control jam-kerja" name="create-desember" required
                                    style="min-width: 60px;">
                                <small id="error-desember" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-icon icon-left btn-primary" id="btn-submit-pelaksana">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
