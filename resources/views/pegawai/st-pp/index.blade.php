@extends('layouts.app')

@section('title', 'ST Pengembangan Profesi')

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
                <h1>ST Pengembangan Profesi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/pegawai/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item">ST Pengembangan Profesi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                    <a href="/pegawai/st-pp/create"
                                        class="btn btn-primary btn-lg btn-round">
                                        + Ajukan Usulan ST
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
                                                <th>Surat Tugas</th>
                                                <th>Jenis PP</th>
                                                <th>Nama PP</th>
                                                <th>Sertifikat</th>
                                                <th>Tanggal Upload Sertifikat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usulan as $un)
                                            <tr>
                                                <td>{{ $usulan->firstItem() + $loop->index }}</td>
                                                <td><a href="/pegawai/st-pp/{{ $un->id }}">{{ $un->tanggal }}</a></td>
                                                <td>
                                                @if ($un->status == 0)
                                                    Menunggu Persetujuan
                                                @elseif ($un->status == 1)
                                                    <a href="/pegawai/st-pp/{{ $un->id }}"><div class="badge badge-danger">Tidak Disetujui</div></a>
                                                @else
                                                    <a target="blank" href="{{ $un->file }}" download>{{ $un->no_st }}</a>
                                                @endif
                                                </td>
                                                <td>{{ $un->pp->jenis }}</td>
                                                <td>{{ $un->nama_pp }}</td>
                                                <td>
                                                    @if ($un->status == 2)
                                                        <a href="#" class="btn btn-icon btn-warning"><i class="fa fa-upload"></i></a>
                                                    @elseif ($un->status == 3)
                                                        Menunggu Persetujuan
                                                    @elseif ($un->status == 4)
                                                        <a href="/pegawai/st-pp/{{ $un->id }}"><div class="badge badge-danger">Tidak Disetujui</div></a>
                                                    @elseif ($un->status == 5)
                                                        <a href="{{ $un->file }}" class="btn btn-icon btn-primary"><i class="fa fa-download"></i></a>
                                                    @endif
                                                </td>
                                                <td>{{ ($un->status == 3 || $un->status == 4 || $un->status == 5) ? $un->tanggal_sertifikat : '' }}</td>
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
@endpush
