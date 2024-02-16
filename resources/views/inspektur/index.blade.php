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
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 dashboard-card px-2">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div class="icon bg-danger"> <i class="fas fa-wrench text-white"></i></i> </div>
                            <div class="ms-2 c-details mx-3">
                                <h6 class="mb-0 text-dark">ST Kinerja</h6> <span>1 days ago</span>
                            </div>
                        </div>
                        <a href="/inspektur/st-kinerja" class="arrow-button-card" type="button"
                            class="rounded-circle"><i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-weight-normal text-dark h5">Usulan Surat Tugas Kinerja</h3>
                        <div class="mt-4">
                            <div class="progress">
                                <div class="progress-bar
                                    @if($stk_sum == 0 || ($stk_sum - $stk_need_approval) / $stk_sum < 0.5)
                                        bg-danger
                                    @elseif(($stk_sum - $stk_need_approval) / $stk_sum < 0.75)
                                        bg-warning
                                    @elseif(($stk_sum - $stk_need_approval) / $stk_sum < 1)
                                        bg-info
                                    @else
                                        bg-success
                                    @endif" role="progressbar"
                                    style="width: {{ ($stk_sum == 0 ? 0 : (($stk_sum - $stk_need_approval) / $stk_sum)) * 100 }}%"
                                    aria-valuenow="{{ (($stk_sum - $stk_need_approval)) * 100 }}" aria-valuemin="0"
                                    aria-valuemax="32"></div>
                            </div>
                            <div class="mt-3"> <span class="text1">{{ $stk_need_approval }} <span class="text2">Dari
                                        {{ $stk_sum }} Dokumen Perlu
                                        Persetujuan</span></span> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 dashboard-card px-2">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row">
                            <div class="icon bg-warning"> <i class="fas fa-briefcase text-white"></i> </div>
                            <div class="ms-2 c-details mx-3">
                                <h6 class="mb-0 text-dark">ST Pengembangan Profesi</h6> <span>4 days ago</span>
                            </div>
                        </div>
                        <a href="/inspektur/st-pp" class="arrow-button-card" type="button" class="rounded-circle"><i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-weight-normal text-dark h5">Usulan Surat Tugas Pengembangan Profesi</h3>
                        <div class="mt-4">
                            <div class="progress">
                                <div class="progress-bar
                                    @if($stp_sum == 0 || ($stp_sum - $stp_need_approval) / $stp_sum < 0.5)
                                        bg-danger
                                    @elseif(($stp_sum - $stp_need_approval) / $stp_sum < 0.75)
                                        bg-warning
                                    @elseif(($stp_sum - $stp_need_approval) / $stp_sum < 1)
                                        bg-info
                                    @else
                                        bg-success
                                    @endif" role="progressbar"
                                    style="width: {{ ($stp_sum == 0 ? 0 : (($stp_sum - $stp_need_approval) / $stp_sum)) * 100 }}%"
                                    aria-valuenow="{{ (($stp_sum - $stp_need_approval)) * 100 }}" aria-valuemin="0"
                                    aria-valuemax="32"></div>
                            </div>
                            <div class="mt-3"> <span class="text1">{{ $stp_need_approval }} <span class="text2">Dari
                                        {{ $stp_sum }} Dokumen Perlu
                                        Persetujuan</span></span> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 dashboard-card px-2">
                <div class="card p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div class="icon bg-primary"> <i class="fas fa-road text-white"></i> </div>
                            <div class="ms-2 c-details mx-3">
                                <h6 class="mb-0 text-dark">ST Perjalanan Dinas</h6> <span>2 days ago</span>
                            </div>
                        </div>
                        <a href="/inspektur/st-pd" class="arrow-button-card" type="button" class="rounded-circle"><i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-weight-normal text-dark h5">Usulan Surat Tugas Perjalanan Dinas</h3>
                        <div class="mt-4">
                            <div class="progress">
                                <div class="progress-bar
                                    @if($stpd_sum == 0 || ($stpd_sum - $stpd_need_approval) / $stpd_sum < 0.5)
                                        bg-danger
                                    @elseif(($stpd_sum - $stpd_need_approval) / $stpd_sum < 0.75)
                                        bg-warning
                                    @elseif(($stpd_sum - $stpd_need_approval) / $stpd_sum < 1)
                                        bg-info
                                    @else
                                        bg-success
                                    @endif" role="progressbar"
                                    style="width: {{ ($stpd_sum == 0 ? 0 : (($stpd_sum - $stpd_need_approval ) / $stpd_sum)) * 100 }}%"
                                    aria-valuenow="{{ ($stpd_sum == 0 ? 0 : (($stpd_sum - $stpd_need_approval ) / $stpd_sum)) * 100 }}"
                                    aria-valuemin="0" aria-valuemax="32"></div>
                            </div>
                            <div class="mt-3"> <span class="text1">{{ $stpd_need_approval }} <span class="text2">Dari
                                        {{ $stpd_sum }} Dokumen Perlu
                                        Persetujuan</span></span> </div>
                        </div>
                    </div>
                </div>
            </div>
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
