<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Penyelenggara Diklat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/analis-sdm/master-penyelenggara" method="post">
                <div class="modal-body">
                    @csrf  
                    <div class="form-group">
                        <label for="penyelenggara">Penyelenggara Diklat</label>
                        <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}">
                        @error('penyelenggara')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>