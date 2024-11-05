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
                            <label class="form-label" for="edit-pegawai">Pegawai<span class="text-danger">*</span></label>
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
                    <div class="form-group">
                        <label class="form-label" for="edit-kat">Kategori<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2 kategori" id="edit-kat" name="edit-kat" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-edit-kat" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-jenis">Jenis<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2 jenis" id="edit-jenis" name="edit-jenis" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                            </select>
                            <small id="error-edit-jenis" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-teknis">Teknis<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2 teknis" id="edit-teknis_id" name="edit-teknis_id" required>
                                <option value="" disabled selected>Pilih Teknis</option>
                            </select>
                            <small id="error-edit-teknis" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-nama_pelatihan">Nama Pelatihan<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="edit-nama_pelatihan" id="edit-nama_pelatihan" required>
                        <small id="error-edit-nama_pelatihan" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-tgl_mulai">Tanggal Mulai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="edit-tgl_mulai" id="edit-tgl_mulai" required>
                        <small id="error-edit-tgl_mulai" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-tgl_selesai">Tanggal Selesai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="edit-tgl_selesai" id="edit-tgl_selesai" required>
                        <small id="error-edit-tgl_selesai" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-durasi">Durasi (Jam)<span class="text-danger">*</span></label>
                        <input type="number" step=".01" class="form-control" name="edit-durasi" id="edit-durasi" required>
                        <small id="error-edit-durasi" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-tgl_sertifikat">Tanggal Sertifikat<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="edit-tgl_sertifikat" id="edit-tgl_sertifikat" required>
                        <small id="error-edit-tgl_sertifikat" class="text-danger"></small>
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
                        <label class="form-label" for="edit-penyelenggara">Penyelenggara<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control select2" id="edit-penyelenggara" name="edit-penyelenggara" required>
                                <option value="" disabled selected>Pilih Penyelenggara</option>
                                @foreach ($penyelenggara as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->penyelenggara }}</option>
                                @endforeach
                            </select>
                            <small id="error-edit-penyelenggara" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-jumlah_peserta">Jumlah Peserta</label>
                        <input type="number" class="form-control" name="edit-jumlah_peserta" id="edit-jumlah_peserta">
                        <small id="error-edit-jumlah_peserta" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-ranking">Ranking</label>
                        <input type="number" class="form-control" name="edit-ranking" id="edit-ranking">
                        <small id="error-edit-ranking" class="text-danger"></small>
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-label" for="edit-catatan">Catatan</label>
                        <div class="">
                            <textarea rows="5" class="form-control h-auto" id="edit-catatan" name="edit-catatan"></textarea>
                        </div>
                    </div> --}}
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
