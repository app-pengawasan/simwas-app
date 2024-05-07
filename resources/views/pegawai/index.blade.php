@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css') }}">

@endpush

@section('main')
@include('components.header')
@include('components.pegawai-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hey, {{ explode(' ', auth()->user()->name)[0] }}</h1>
        </div>
        {{-- form action year --}}
        <form id="yearForm" action="" method="GET" class="col-md-1 px-0">
            @csrf
            <div class="form-group">
                <label for="yearSelect">Pilih Tahun</label>
                <select name="year" id="yearSelect" class="form-control select2">
                    @php
                    $currentYear = date('Y');
                    $lastThreeYears = range($currentYear, $currentYear - 3);
                    @endphp

                    @foreach ($lastThreeYears as $year)
                    <option value="{{ $year }}" {{ request()->query('year') == $year ? 'selected' : '' }}>{{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
        @include('components.pegawai.pegawai-card')
        @include('components.pegawai.ketua-tim-card')
        @include('components.pegawai.pimpinan-card')
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
<script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('js') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('js') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('js') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

<script src="{{ asset('js') }}/page/pegawai-pengelolaan-dokumen.js"></script>

<script>
    $('#yearSelect').on('change', function() {
        let year = $(this).val();
        $('#yearForm').attr('action', `?year=${year}`);
        $('#yearForm').find('[name="_token"]').remove();
        $('#yearForm').submit();
    });
</script>

@endpush
