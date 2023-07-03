<div class="modal fade" id="modal-edit-pelaksana" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-edit-pelaksana-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-pelaksana-label">Form Edit Pelaksana Tugas</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <input type="hidden" id="edit-id_pelaksana" name="id_pelaksana">
                    <div class="form-group">
                        <label class="form-label" for="edit-pt-jabatan">Jabatan</label>
                        <div class="">
                            <select id="edit-pt-jabatan" class="form-control" name="edit-pt-jabatan" disabled required>
                                <option value="1">Pengendali Teknis</option>
                                <option value="2">Ketua Tim</option>
                                <option value="3">PIC</option>
                                <option value="4">Anggota Tim</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-pt-hasil">Hasil Kerja</label>
                        <div class="">
                            <select id="edit-pt-hasil" class="form-control" name="edit-pt-hasil" required>
                                @foreach ($allHasilKerja as $hasilkerja)
                                    <option value="{{ $hasilkerja->kategori_hasilkerja }}">
                                        {{ $masterHasilKerja[$hasilkerja->kategori_hasilkerja] }}
                                    </option>
                                @endforeach
                                <option value="2">Kertas Kerja</option>
                            </select>
                            <small id="error-edit-hasil_kerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-pelaksana">Nama</label>
                        <div class="">
                            <select id="edit-pelaksana" class="form-control" name="edit-pelaksana">
                                <option value="" selected disabled></option>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <small id="error-edit-pelaksana" class="text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                    <i class="fas fa-exclamation-triangle"></i>Batal
                </button>
                <button type="submit" class="btn btn-icon icon-left btn-primary" id="btn-edit-pelaksana">
                    <i class="fas fa-save"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
