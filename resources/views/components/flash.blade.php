@if (session('status'))
    <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert">
        {!! session('status') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding-top: 0; padding-right: 5px">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
