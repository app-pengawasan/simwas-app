<div class="modal fade" id="modalEditSurat" tabindex="-1" role="dialog" aria-labelledby="modalEditSuratLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('sekretaris.surat-srikandi.update', $usulanSuratSrikandi->suratSrikandi[0]->id)
             }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSetujuiSuratLabel">Edit Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="pejabat_penanda_tangan"
                    value="{{ $usulanSuratSrikandi->pejabat_penanda_tangan }}">
                <div class="modal-body">
                    {{-- hidden form id $usulanSuratSrikandi --}}
                    <input type="hidden" name="usulan_surat_srikandi_id" value="{{ $usulanSuratSrikandi->id }}">
                    {{-- jenis naskah dinas --}}
                    <div class="form-group">
                        <label for="edit-jenisNaskahDinas">Jenis Naskah Dinas</label>
                        <select required
                            class="form-control select2 @error('edit-jenisNaskahDinas') is-invalid @enderror"
                            id="edit-jenisNaskahDinas" name="jenisNaskahDinas">
                            <option disabled selected value="">Pilih Jenis Naskah Dinas</option>
                            @foreach ($jenisNaskahDinas as $jenisNaskahDinas)
                            <option {{
                                    $usulanSuratSrikandi->suratSrikandi[0]->jenis_naskah_dinas_srikandi == $jenisNaskahDinas ? 'selected' : ''
                                }} value="{{ $jenisNaskahDinas }}">
                                {{ $jenisNaskahDinas }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Jenis Naskah Dinas Harus Diisi</div>
                    </div>
                    {{-- tanggal persetujuan srikandi --}}
                    <div class="form-group
                        {{ $errors->has('tanggal_persetujuan_srikandi') ? 'has-error' : '' }}">
                        <label for="edit-tanggal_persetujuan_srikandi">Tanggal Persetujuan Srikandi</label>
                        <input required type="date" class="form-control" name="tanggal_persetujuan_srikandi"
                            id="edit-tanggal_persetujuan_srikandi"
                            value="{{ $usulanSuratSrikandi->suratSrikandi[0]->tanggal_persetujuan_srikandi }}">
                        @if ($errors->has('tanggal_persetujuan_srikandi'))
                        <span class="help-block
                            text-danger">{{ $errors->first('tanggal_persetujuan_srikandi') }}</span>
                        @endif
                    </div>
                    {{-- nomor surat srikandi --}}
                    <div class="form-group
                        {{ $errors->has('nomor_surat_srikandi') ? 'has-error' : '' }}">
                        <label for="edit-nomor_surat_srikandi">Nomor Surat Srikandi</label>
                        <input required type="text" class="form-control" name="nomor_surat_srikandi"
                            id="edit-nomor_surat_srikandi"
                            value="{{ $usulanSuratSrikandi->suratSrikandi[0]->nomor_surat_srikandi }}">
                        @if ($errors->has('nomor_surat_srikandi'))
                        <span class="help-block
                            text-danger">{{ $errors->first('nomor_surat_srikandi') }}</span>
                        @endif
                    </div>
                    {{-- derajat keamanan --}}
                    <div class="form-group">
                        <label for="edit-derajatKeamanan">Derajat Keamanan</label>
                        <select required class="form-control select2 @error('derajatKeamanan') is-invalid @enderror"
                            id="edit-derajatKeamanan" name="derajatKeamanan">
                            <option disabled selected value="">Pilih Kegiatan Derajat Keamanan
                            </option>
                            @foreach ($derajatKeamanan as $derajatKeamanan)
                            <option {{
                            $usulanSuratSrikandi->suratSrikandi[0]->derajat_keamanan_srikandi == $derajatKeamanan ? 'selected' : ''
                            }}
                                value="{{ $derajatKeamanan }}">
                                {{ $derajatKeamanan }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Derajat Kemanan Harus Diisi</div>
                    </div>
                    {{-- kode klasifikasi arsip --}}
                    <div class="form-group">
                        <label for="edit-kodeKlasifikasiArsip">Kode Klasifikasi Arsip</label>
                        <select required class="form-control select2
                            @error('edit-kodeKlasifikasiArsip') is-invalid @enderror" id="edit-kodeKlasifikasiArsip"
                            name="kodeKlasifikasiArsip">
                            <option disabled selected value="">Pilih Kode Klasifikasi Arsip</option>
                            @foreach ($kodeKlasifikasiArsip as $kodeKlasifikasiArsip)
                            <option {{ $usulanSuratSrikandi->suratSrikandi[0]->kode_klasifikasi_arsip_srikandi == $kodeKlasifikasiArsip->id ? 'selected' : '' }}
                                value="{{ $kodeKlasifikasiArsip->id }}">
                                {{ $kodeKlasifikasiArsip->nama }}{{ $kodeKlasifikasiArsip->uraian }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Kode Klasifikasi Arsip Harus Diisi</div>
                    </div>
                    {{-- perihal --}}
                    <div class="form-group">
                        <label for="edit-melaksanakan">Melaksanakan</label>
                        <input required placeholder="Input Untuk Melaksanakan" type="text"
                            class="form-control @error('melaksanakan') is-invalid @enderror" id="edit-melaksanakan"
                            name="melaksanakan" value="{{ $usulanSuratSrikandi->suratSrikandi[0]->perihal_srikandi }}">
                        <div class="invalid-feedback">Melaksanakan Harus Diisi</div>
                    </div>
                    {{-- kepala unit penanda tangan --}}
                    <div class="form-group">
                        <label for="edit-pejabatPenandaTangan">Pejabat Penanda Tangan</label>
                        <select required
                            class="form-control select2 @error('pejabatPenandaTangan') is-invalid @enderror"
                            id="edit-pejabatPenandaTangan" name="pejabatPenandaTangan">
                            <option disabled selected value="">Pilih Pejabat Penanda Tangan</option>
                            @foreach ($pejabatPenandaTangan as $pejabatPenandaTangan)
                            <option {{$usulanSuratSrikandi->suratSrikandi[0]->kepala_unit_penandatangan_srikandi == $pejabatPenandaTangan ? 'selected' : '' }}
                                value="{{ $pejabatPenandaTangan }}">
                                {{ $pejabatPenandaTangan }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Pejabat Penanda Tangan Harus Diisi</div>
                    </div>
                    {{-- link srikandi --}}
                    <div class="form-group
                        {{ $errors->has('link_srikandi') ? 'has-error' : '' }}">
                        <label for="link_srikandi">Link Srikandi</label>
                        <input required type="url" class="form-control" name="link_srikandi" id="link_srikandi"
                            value="{{ $usulanSuratSrikandi->suratSrikandi[0]->link_srikandi }}">
                        @if ($errors->has('link_srikandi'))
                        <span class="help-block
                            text-danger">{{ $errors->first('link_srikandi') }}</span>
                        @endif
                    </div>
                    {{-- upload word document --}}
                    <div class="form-group
                        {{ $errors->has('upload_word_document') ? 'has-error' : '' }}">
                        <label for="edit-upload_word_document">Upload Word Document</label>
                        <input type="file" class="form-control" name="upload_word_document"
                            id="edit-upload_word_document"
                            accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            value="{{ old('upload_word_document') }}">
                        @if ($errors->has('upload_word_document'))
                        <span class="help-block
                            text-danger">{{ $errors->first('upload_word_document') }}</span>
                        @endif
                    </div>
                    {{-- upload pdf document --}}
                    <div class="form-group
                        {{ $errors->has('upload_pdf_document') ? 'has-error' : '' }}">
                        <label for="edit-upload_pdf_document">Upload PDF Document</label>
                        <input type="file" class="form-control" name="upload_pdf_document"
                            id="edit-upload_pdf_document" accept="application/pdf" value="{{ old('upload_pdf_document') }}">
                        @if ($errors->has('upload_pdf_document'))
                        <span class="help-block
                            text-danger">{{ $errors->first('upload_pdf_document') }}</span>
                        @endif
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
