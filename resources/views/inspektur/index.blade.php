@extends('layouts.app')

@section('title', 'Inspektur')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
@include('components.inspektur-header')
@include('components.inspektur-sidebar')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Inspektur Dashboard</h1>
        </div>
        <div class="row">

            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Usulan ST Kinerja</h4>
                        </div>
                        <div class="card-body">
                            {{ $stk }}
        </div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Usulan ST Pengembangan Profesi</h4>
            </div>
            <div class="card-body">
                {{ $stp }}
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
            <i class="fas fa-road"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Usulan ST Perjalanan Dinas</h4>
            </div>
            <div class="card-body">
                {{ $stpd }}
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
</div>
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

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
