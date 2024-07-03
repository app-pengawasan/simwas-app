<div class="modal fade" id="modal-create-tim-norma-hasil" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tim-norma-hasil-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tim-norma-hasil-label">Norma Hasil</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNHtim" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label required" for="jenis">Jenis</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="jenis" value="1" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Laporan</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenis" value="2" class="selectgroup-input">
                                <span class="selectgroup-button">Dokumen</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tugas">Tugas</label>
                        <div class="">
                            <select class="form-control" id="tugas" name="tugas" required>
                                <option value="" selected disabled>Pilih Tugas</option>
                                @foreach ($tugasSaya as $ts)
                                    <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
                                @endforeach
                            </select>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>

                    {{-- form jenis laporan --}}
                    <div class="form-group form-laporan">
                        <label class="form-label" for="nomor">Nomor Dokumen</label>
                        <div class="">
                            <select class="form-control" id="nomor" name="nomor" required>
                                <option id="nomor-dis" value="" selected disabled>Pilih Nomor Dokumen</option>
                                @foreach ($draf as $un)
                                    <option value="{{ $un->id }}" data-nama="{{ $un->nama_dokumen }}" data-tugas="{{ $un->tugas_id }}" data-bulan="{{ $un->laporan_pengawasan_id }}">
                                        R-{{ $un->normaHasilAccepted->nomor_norma_hasil}}/{{ $un->normaHasilAccepted->unit_kerja}}/{{ $un->normaHasilAccepted->kode_klasifikasi_arsip}}/{{ $un->masterLaporan->kode ?? "" }}/{{ date('Y', strtotime($un->normaHasilAccepted->tanggal_norma_hasil)) }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-nomor" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-laporan">
                        <label class="form-label" for="nama">Nama Dokumen</label>
                        <div class="">
                            <input type="text" name="nama" id="nama" class="form-control" required disabled>
                        </div>
                    </div>

                    {{-- form jenis dokumen --}}
                    <div class="form-group form-dokumen">
                        <label class="form-label" for="objek">Objek Pengawasan</label>
                        <div class="">
                            <select class="form-control" id="objek" name="objek" required>
                                <option value="" selected disabled id="objek-dis">Pilih Objek</option>
                                @foreach ($oPengawasan as $objek)
                                    <option value="{{ $objek->id_opengawasan }}" 
                                        data-tugas="{{ $objek->id_rencanakerja }}">{{ $objek->nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-objek" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bulan">Bulan Pelaporan</label>
                        <div class="">
                            <select class="form-control" id="bulan" name="bulan" required>
                                <option value="" selected disabled id="bulan-dis">Pilih Bulan</option>
                                @foreach ($bulanPelaporan as $bulan)
                                    <option value="{{ $bulan->id }}" 
                                        data-objek="{{ $bulan->id_objek_pengawasan }}">{{ $months[$bulan->month] }}</option>
                                @endforeach
                            </select>
                            <small id="error-bulan" class="text-danger"></small>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="form-label" for="file">File Norma Hasil</label>
                        <div class="">
                            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
                            <small id="error-file" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-icon icon-left btn-danger" data-dismiss="modal">
                        <i class="fas fa-exclamation-triangle"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-icon icon-left btn-primary submit-btn">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
