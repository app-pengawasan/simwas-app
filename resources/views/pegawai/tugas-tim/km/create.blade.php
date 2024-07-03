<div class="modal fade" id="modal-create-tim-km" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-tim-km-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-tim-km-label">Kendali Mutu</h5>
                <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNHtim" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="is_ada" value="1" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Ada</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="is_ada" value="0" class="selectgroup-input1">
                                <span class="selectgroup-button1">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tugas">Tugas</label>
                        <div class="">
                            <select required id="tugas" name="tugas" class="form-control">
                                <option value="" selected disabled>Pilih Tugas</option>
                                @foreach ($tugasSaya as $ts)
                                    {{-- @if (!isset($ts->rencanaKerja->kendaliMutu))
                                        <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
                                    @endif --}}
                                    <option value="{{ $ts->id_rencanakerja }}">{{ $ts->rencanaKerja->tugas }}</option>
                                @endforeach
                            </select>
                            <small id="error-tugas" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="objek">Objek Pengawasan</label>
                        <div class="">
                            <select required id="objek" name="objek" class="form-control">
                                <option value="" selected disabled>Pilih Objek</option>
                                @foreach ($oPengawasan as $objek)
                                    <option value="{{ $objek->id_opengawasan }}" data-tugas="{{ $objek->id_rencanakerja }}">{{ $objek->nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-objek" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bulan">Bulan Pelaporan</label>
                        <div class="">
                            <select required id="bulan" name="bulan" class="form-control">
                                <option value="" selected disabled>Pilih Bulan</option>
                                @foreach ($bulanPelaporan as $bulan)
                                    <option value="{{ $bulan->id }}" data-objek="{{ $bulan->id_objek_pengawasan }}">{{ $months[$bulan->month] }}</option>
                                @endforeach
                            </select>
                            <small id="error-bulan" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-ada">
                        <label class="form-label" for="file">File Kendali Mutu</label>
                        <div class="">
                            <input type="url" name="link" id="link" class="form-control link" placeholder="Link File Kendali Mutu" required>
                            <small id="error-link" class="text-danger"></small>

                            <div class="d-flex mt-2 align-items-center">
                                <label for="file" style="color: #34395e; width: 24%" class="mt-2">
                                    <em>atau upload file</em>
                                </label>
                                <input type="file" name="file" id="file" class="form-control file" accept=".rar, .zip" required>
                                <button type="button" class="btn btn-primary ml-2 h-100 clear" id="clear">
                                    Clear
                                </button>
                            </div>
                            <small id="error-file" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group form-tidak">
                        <label class="form-label" for="catatan">Catatan</label>
                        <div class="">
                            <textarea rows="4" class="form-control h-auto" id="catatan" name="catatan" required></textarea>
                            <small id="error-catatan" class="text-danger"></small>
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