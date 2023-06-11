<div class="modal fade" id="modal-create-masterhasil" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-masterhasil-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-masterhasil-label">Form Tujuan Inspektorat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('master-hasil.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="unsur">Unsur</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="unsur" id="unsur" required>
                                <option value="" selected disabled>Pilih Unsur</option>
                                @foreach ($unsur as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="subunsur1">Subunsur 1</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="subunsur1" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="subunsur2">Subunsur 2</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="subunsur2" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kategori_hasilkerja">Hasil Kerja</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategori_hasilkerja" id="kategori_hasilkerja" required>
                                <option value="" selected disabled>Pilih Hasil Kerja</option>
                                @foreach ($hasilKerja as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kategori_pelaksana">Pelaksana Tugas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategori_pelaksana" id="kategori_pelaksana" required>
                                <option value="" selected disabled>Pilih Ketgori Pelaksana Tugas</option>
                                @foreach ($pelaksanaTugas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                <option value="" disabled></option>
                            </select>
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
