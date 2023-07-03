<div class="modal fade" id="modal-create-pelaksana" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-pelaksana-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
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
                        <label class="label" for="pt-jabatan">Jabatan</label>
                        <div class="">
                            <select id="pt-jabatan" class="form-control" name="pt-jabatan" disabled required>
                                <option value="1">Pengendali Teknis</option>
                                <option value="2">Ketua Tim</option>
                                <option value="3">PIC</option>
                                <option value="4">Anggota Tim</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label" for="pt-hasil">Hasil Kerja</label>
                        <div class="">
                            <select id="pt-hasil" class="form-control" name="pt-hasil" disabled required>
                                @foreach ($allHasilKerja as $hasilkerja)
                                    <option value="{{ $hasilkerja->kategori_hasilkerja }}">
                                        {{ $masterHasilKerja[$hasilkerja->kategori_hasilkerja] }}
                                    </option>
                                @endforeach
                                <option value="2">Kertas Kerja</option>
                            </select>
                            <small id="error-hasil_kerja" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label" for="pelaksana">Nama</label>
                        <div class="">
                            <select id="pelaksana" class="form-control" name="pelaksana">
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
