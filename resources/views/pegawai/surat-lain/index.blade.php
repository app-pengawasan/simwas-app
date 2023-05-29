@extends('layouts.app')

@section('title', 'Surat Lain')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('header-app')
@endsection
@section('sidebar')
@endsection

@section('main')
    @include('components.header')
    @include('components.pegawai-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Surat Lain</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">Surat Lain</div>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                    <a href="/pegawai/surat-lain/create"
                                        class="btn btn-primary btn-lg btn-round">
                                        + Ajukan Usulan Surat
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table-striped table"
                                        id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Tanggal</th>
                                                <th>Jenis</th>
                                                <th>Nomor</th>
                                                <th>Status Surat</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usulan as $un)
                                            <tr>
                                                <td>{{ $usulan->firstItem() + $loop->index }}</td>
                                                <td><a href="/pegawai/surat-lain/{{ $un->id }}">{{ $un->tanggal }}</a></td>
                                                <td>{{ $un->jenisSurat->nama }}</a></td>
                                                <td>
                                                    @if($un->status == 0)
                                                        Menunggu Persetujuan
                                                    @elseif($un->status == 1)
                                                    <a href="/pegawai/surat-lain/{{ $un->id }}"><div class="badge badge-danger">Tidak Disetujui</div></a>
                                                    @else
                                                        <a href="/pegawai/surat-lain/{{ $un->id }}">{{ $un->no_surat }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($un->status == 2)
                                                    <a target="blank" class="btn btn-sm btn-warning" href="{{ $un->jenisSurat->file }}" download>Unduh Form</a><a class="btn btn-sm btn-info" href="{{ route('surat-lain.edit', ['surat_lain' => $un->id]) }}">Upload Surat</a>
                                                    @elseif($un->status == 3)
                                                        Menunggu Persetujuan
                                                    @elseif($un->status == 4)
                                                        <a href="/pegawai/surat-lain/{{ $un->id }}"><div class="badge badge-danger">Tidak Disetujui</div></a>
                                                    @elseif($un->status == 5)
                                                        Disetujui
                                                    @endif
                                                </td>
                                                <td>
                                                @if($un->status == 3 || $un->status == 4 || $un->status == 5)
                                                    <a target="blank" href="{{ asset('storage/'.$un->surat) }}" download><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
                                                @endif
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $usulan->links() }}  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    {{-- laravel pagination --}}
    
@endpush
