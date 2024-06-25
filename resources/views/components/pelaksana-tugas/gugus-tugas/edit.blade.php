<div class="modal fade" id="modal-edit-pelaksana" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal-edit-pelaksana-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-pelaksana-label">Form Edit Pelaksana Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-id_pelaksana" name="id_pelaksana">
                <div class="form-group">
                    <label class="form-label" for="edit-pt-jabatan">Jabatan</label>
                    <select id="edit-pt-jabatan" class="form-control" name="edit-pt-jabatan" disabled required>
                        <option value="1">Pengendali Teknis</option>
                        <option value="2">Ketua Tim</option>
                        <option value="3">PIC</option>
                        <option value="4">Anggota Tim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit-pelaksana">Nama</label>
                    <select id="edit-pelaksana" class="form-control select2" name="edit-pelaksana">
                        <option value="" selected disabled></option>
                        @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600px;">Kebutuhan Jam Kerja Per Bulan</label>
                    <span class="text-danger text-sm font-weight-normal">*bilangan bulat atau desimal (0,5)</span>
                    <div id="month-wrap">
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-januari">Januari</label>
                            <input type="text" id="edit-januari" class="form-control jam-kerja" name="edit-januari"
                                required style="min-width: 60px;">
                            <small id="error-edit-januari" class="text-danger"></small>
                        </div>
                        {{-- februari --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-februari">Februari</label>
                            <input type="text" id="edit-februari" class="form-control jam-kerja" name="edit-februari"
                                required style="min-width: 60px;">
                            <small id="error-edit-februari" class="text-danger"></small>
                        </div>
                        {{-- maret --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-maret">Maret</label>
                            <input type="text" id="edit-maret" class="form-control jam-kerja" name="edit-maret" required
                                style="min-width: 60px;">
                            <small id="error-edit-maret" class="text-danger"></small>
                        </div>
                        {{-- april --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-april">April</label>
                            <input type="text" id="edit-april" class="form-control jam-kerja" name="edit-april" required
                                style="min-width: 60px;">
                            <small id="error-edit-april" class="text-danger"></small>
                        </div>
                        {{-- mei --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-mei">Mei</label>
                            <input type="text" id="edit-mei" class="form-control jam-kerja" name="edit-mei" required
                                style="min-width: 60px;">
                            <small id="error-edit-mei" class="text-danger"></small>
                        </div>
                        {{-- juni --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-juni">Juni</label>
                            <input type="text" id="edit-juni" class="form-control jam-kerja" name="edit-juni" required
                                style="min-width: 60px;">
                            <small id="error-edit-juni" class="text-danger"></small>
                        </div>
                        {{-- juli --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-juli">Juli</label>
                            <input type="text" id="edit-juli" class="form-control jam-kerja" name="edit-juli" required
                                style="min-width: 60px;">
                            <small id="error-edit-juli" class="text-danger"></small>
                        </div>
                        {{-- agustus --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-agustus">Agustus</label>
                            <input type="text" id="edit-agustus" class="form-control jam-kerja" name="edit-agustus"
                                required style="min-width: 60px;">
                            <small id="error-edit-agustus" class="text-danger"></small>
                        </div>
                        {{-- september --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-september">September</label>
                            <input type="text" id="edit-september" class="form-control jam-kerja" name="edit-september"
                                required style="min-width: 60px;">
                            <small id="error-edit-september" class="text-danger"></small>
                        </div>
                        {{-- oktober --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-oktober">Oktober</label>
                            <input type="text" id="edit-oktober" class="form-control jam-kerja" name="edit-oktober"
                                required style="min-width: 60px;">
                            <small id="error-edit-oktober" class="text-danger"></small>
                        </div>
                        {{-- november --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-november">November</label>
                            <input type="text" id="edit-november" class="form-control jam-kerja" name="edit-november"
                                required style="min-width: 60px;">
                            <small id="error-edit-november" class="text-danger"></small>
                        </div>
                        {{-- desember --}}
                        <div class="d-flex flex-column">
                            <label class="form-label
                                                    " for="edit-desember">Desember</label>
                            <input type="text" id="edit-desember" class="form-control jam-kerja" name="edit-desember"
                                required style="min-width: 60px;">
                            <small id="error-edit-desember" class="text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                        class="fas fa-exclamation-triangle"></i>Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-edit-pelaksana"><i
                        class="fas fa-save"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>
