@extends('layouts.app')

@section('title', 'Admin')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
@include('components.admin-header')
@include('components.admin-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Admin Dashboard</h1>
        </div>
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
        @include('components.admin.admin-card')
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script>
    $('#yearSelect').on('change', function() {
        let year = $(this).val();
        $('#yearForm').attr('action', `?year=${year}`);
        $('#yearForm').find('[name="_token"]').remove();
        $('#yearForm').submit();
    });
</script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
