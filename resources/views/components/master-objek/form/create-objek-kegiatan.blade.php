<div class="modal fade" id="modal-create-objekkegiatan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-objekkegiatan-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-objekkegiatan-label">Form Tambah wilayah Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('objek-kegiatan.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="nama_unitkerja" name="nama_unitkerja">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kode_unitkerja">Kegiatan</label>
                        <div class="col-sm-10">
                            <select id="kode_unitkerja" class="form-control" name="kode_unitkerja" required>
                                <option value="" disabled selected>Pilih Unit Kerja</option>
                                @foreach ($master_unitkerja as $unitkerja)
                                    <option value="{{ $unitkerja->kode_unitkerja }}"
                                        {{ $unitkerja->kode_unitkerja == old('kode_unitkerja') ? 'selected' : '' }}>
                                        {{ $unitkerja->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kode_kegiatan">Kode Kegiatan</label>
                        <div class="col-sm-10">
                            <input type="text" id="kode_kegiatan" class="form-control" name="kode_kegiatan"
                                value="{{ old('kode_kegiatan') }}" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" value="{{ old('nama') }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
