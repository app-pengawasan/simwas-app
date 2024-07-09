<div class="card col-md-12 p-0 pr-2">
    <div class="card-body shadow-sm border p-4">
        <div class="h4 text-dark mb-4 d-flex align-items-center header-card">
            <div class="badge alert-primary mr-2 d-flex justify-content-center align-items-center"
                style="width: 30px; height: 30px">
                <i class="fa-solid fa-clipboard-check fa-xs"></i>
            </div>
            <h1 class="h4 text-dark mb-0">
                Informasi Surat Srikandi
            </h1>
        </div>
        <table class="mb-4 table table-striped responsive" id="table-show">
            <tr>
                <th>Pejabat Penanda Tangan:</th>
                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->kepala_unit_penandatangan_srikandi}}
                </td>
            </tr>
            {{-- nomor_surat_srikandi --}}
            <tr>
                <th>Nomor Surat Srikandi:</th>
                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->nomor_surat_srikandi }}</td>
            </tr>
            <tr>
                <th>Dokumen Surat Srikandi:</th>
                <td>
                    <a class="badge badge-danger p-2" target="_blank"
                        href="/{{ $usulanSuratSrikandi->suratSrikandi[0]->document_srikandi_pdf_path }}">
                        <i class="fa-solid fa-file-pdf mr-1"></i>Download</a>
                    <a class="badge badge-info p-2" target="_blank"
                        href="/{{ $usulanSuratSrikandi->suratSrikandi[0]->document_srikandi_word_path }}">
                        <i class="fa-solid fa-file-word mr-1"></i>Download</a>

            <tr>
                <th>Jenis Naskah Dinas:</th>
                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->jenis_naskah_dinas_srikandi }}
                </td>
            </tr>
            <tr>
                <th>Tanggal Persetujuan Srikandi:</th>
                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->tanggal_persetujuan_srikandi }}
                </td>
            </tr>
            <tr>
                <th>Derajat Keamanan:</th>
                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->derajat_keamanan_srikandi }}</td>
            </tr>
            <tr>
                <th>Kode Klasifikasi Arsip:</th>
                <td>{{ $usulanSuratSrikandi->suratSrikandi[0]->kodeKlasifikasiArsip->kode ?? ''}}
                    {{ $usulanSuratSrikandi->suratSrikandi[0]->kodeKlasifikasiArsip->uraian ?? '' }}
                </td>
            </tr>
            <tr>
                <th>Link Srikandi</th>
                <td>
                    <a target="_blank" class="badge badge-primary"
                        href="{{ $usulanSuratSrikandi->suratSrikandi[0]->link_srikandi }}">
                        {{ $usulanSuratSrikandi->suratSrikandi[0]->link_srikandi }}
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>
