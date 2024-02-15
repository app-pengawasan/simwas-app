@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Mohon Maaf, </strong> Terdapat kesalahan dalam pengisian formulir. Silakan periksa
    kembali data yang diinputkan.
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
