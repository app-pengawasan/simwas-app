<div class="modal fade" id="modal-edit-kompetensi" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-kompetensi-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-kompetensi-label">Form Edit Kompetensi</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" class="" name="myeditform" id="myeditform">
                <input type="hidden" id="edit-id">
                <div class="modal-body">
                    <input type="hidden" name="role" id="role" value="{{ $role }}">
                    @if ($role == 'analis sdm')
                        <div class="form-group">
                            <label class="form-label" for="edit-pegawai">Pegawai</label>
                            <div class="">
                                <select class="form-control" id="edit-pegawai" name="edit-pegawai" required disabled>
                                    <option value="" disabled selected>Pilih Pegawai</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->name }}</option>
                                    @endforeach
                                    <option value="" disabled></option>
                                </select>
                                <small id="error-edit-pegawai" class="text-danger"></small>
                            </div>
                        </div>
                    @endif
                    <div class="form-group div_create_pp">
                        <label class="form-label" for="edit-pp">Jenis Pengembangan Kompetensi</label>
                        <div class="">
                            <select class="form-control pp_id" id="edit-pp" name="edit-pp" required>
                                <option value="" disabled selected>Pilih Jenis Pengembangan</option>
                                @foreach ($pps as $pp)
                                <option value="{{ $pp->id }}">
                                    {{ $pp->jenis }}</option>
                                @endforeach
                                {{-- <option value="999">Lainnya</option> --}}
                                <option value="" disabled></option>
                            </select>
                            <small id="error-edit-pp" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-inline form-one-line form-other-pp mt-3">
                        <label class="form-label" for="edit-pp_lain">Sebutkan:</label>
                        <input type="text" name="edit-pp_lain" id="edit-pp_lain" class="form-control ml-3 pp_lain">
                        <small id="error-edit-pp_lain" class="text-danger"></small>
                    </div>
                    <div class="form-group div_create_peserta">
                        <label class="form-label" for="edit-peserta">Peserta</label>
                        <div class="">
                            <select class="form-control peserta" id="edit-peserta" name="edit-peserta" required>
                                <option value="" disabled selected>Pilih Peserta</option>
                                <option value="100">Pengawasan (Auditor Pertama)</option>
                                <option value="200">Auditor Muda</option>
                                <option value="300">Auditor Madya/Utama</option>
                                <option value="400">Semua Jenjang</option>
                            </select>
                            <small id="error-edit-peserta" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group div_create_namapp">
                        <label class="form-label" for="edit-nama_pp">Nama Pengembangan Kompetensi</label>
                        <div class="">
                            <select class="form-control nama_pp_id" name="edit-nama_pp" id="edit-nama_pp" required disabled>
                                <option value="" selected disabled class="disabled">Pilih Nama Pengembangan</option>
                                @foreach ($nama_pps as $nama_pp)
                                    <option value="{{ $nama_pp->id }}" data-pp="{{ $nama_pp->pp_id }}" data-peserta="{{ $nama_pp->peserta }}">{{ $nama_pp->nama }}</option>
                                @endforeach
                                {{-- <option value="999">Lainnya</option> --}}
                                <option value="" disabled></option>
                            </select>
                            <small id="error-edit-nama_pp" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-inline form-one-line form-other-namepp mt-3">
                        <label class="form-label" for="edit-nama_pp_lain">Sebutkan:</label>
                        <input type="text" name="edit-nama_pp_lain" id="edit-nama_pp_lain" class="form-control ml-3 nama_pp_lain">
                        <small id="error-edit-nama_pp_lain" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-sertifikat">Sertifikat</label>
                        <input type="file" class="form-control" name="edit-sertifikat" accept=".pdf">
                        <div class="invalid-feedback">
                            File belum ditambahkan
                        </div>
                        <small id="error-edit-sertifikat" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-catatan">Catatan</label>
                        <div class="">
                            <textarea rows="5" class="form-control h-auto" id="edit-catatan" name="edit-catatan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" id="btn-edit-submit" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
