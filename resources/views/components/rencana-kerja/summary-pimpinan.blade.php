<?php setlocale(LC_ALL, 'id-ID', 'id_ID'); ?>
<div class="modal fade" id="modal-summary" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-summary-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-summary-label">Ringkasan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <table class="mb-4">
                            <tr>
                                <th style="min-width: 94pt">Tujuan</th>
                                <td>{{ $timKerja->iku->sasaran->tujuan->tujuan }}</td>
                            </tr>
                            <tr>
                                <th>Sasaran</th>
                                <td>{{ $timKerja->iku->sasaran->sasaran }}</td>
                            </tr>
                            <tr>
                                <th>IKU</th>
                                <td>{{ $timKerja->iku->iku }}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>{{ $timKerja->nama }}</td>
                            </tr>
                            <tr>
                                <th>Unit Kerja</th>
                                <td>{{ $unitKerja[$timKerja->unitkerja] }}</td>
                            </tr>
                            <tr>
                                <th>Ketua</th>
                                <td>{{ $timKerja->ketua->name }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $timKerja->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Total Anggaran</th>
                                <td class="rupiah">
                                    <?php $totalAnggaran = 0; ?>
                                    @foreach ($timKerja->rencanaKerja as $rk)
                                        <?php $totalAnggaran += $rk->anggaran->sum('total'); ?>
                                    @endforeach
                                    {{ $totalAnggaran }}
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $statusTim[$timKerja->status] }}</td>
                            </tr>
                        </table>
                        <h4 class="mt-4">Tugas</h4>
                        <ol>
                            @foreach ($rencanaKerja as $tugas)
                                <li>{{ $tugas->tugas }}</li>
                            @endforeach
                        </ol>
                        <h4 class="mt-4">Rincian</h4>
                        <ol>
                            @foreach ($rencanaKerja as $tugas)
                                <li class="font-weight-bold mt-4">
                                    <p>{{ $tugas->tugas }}</p>
                                </li>
                                <table>
                                    <tr>
                                        <th valign=top style="min-width: 64px">Objek</th>
                                        <td>
                                            @if (count($tugas->objekPengawasan) > 0)
                                                @foreach ($tugas->objekPengawasan as $objek)
                                                    <p>{{ $loop->iteration }}. {{ $objek->nama }}</p>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Waktu</th>
                                        <td class="pl-4">
                                            {{ strftime('%A, %d %B %Y', strtotime($tugas->mulai)) }} -
                                            {{ strftime('%A, %d %B %Y', strtotime($tugas->selesai)) }}
                                        </td>
                                    </tr>
                                </table>
                                <p class="font-weight-bold">
                                    Pelaksana
                                </p>
                                <table class="table table-striped">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Hasil Kerja</th>
                                    </tr>
                                    @if (count($tugas->pelaksana) > 0)
                                        @foreach ($tugas->pelaksana as $pelaksana)
                                            <tr>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $pelaksana->user->name }}</td>
                                                <?php
                                                $jabatanPelaksana = ['', 'Pengendali Teknis', 'Ketua Tim', 'PIC', 'Anggota Tim'];
                                                $hasilKerja2 = ['', 'Lembar Reviu', 'Kertas Kerja'];
                                                ?>
                                                <td>{{ $jabatanPelaksana[$pelaksana->pt_jabatan] }}</td>
                                                <td>
                                                    @if ($tugas->kategori_pelaksanatugas == 'gt')
                                                        {{ $hasilKerja2[$pelaksana->pt_hasil] }}
                                                    @elseif ($pelaksana->pt_jabatan == 4)
                                                        Kertas Kerja
                                                    @else
                                                        {{ $hasilKerja[$pelaksana->pt_hasil] }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="font-italic text-center" colspan="4">Tidak terdapat data
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                                <p class="font-weight-bold">Anggaran</p>
                                @if (count($tugas->anggaran))
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Uraian</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                        </tr>
                                        <?php $totalAnggaran = 0; ?>
                                        @foreach ($tugas->anggaran as $anggaran)
                                            <tr>
                                                <td>{{ $anggaran->uraian }}</td>
                                                <td>{{ $anggaran->volume }}</td>
                                                <td>{{ $satuan[$anggaran->satuan] }}</td>
                                                <td class="rupiah">{{ $anggaran->harga }}</td>
                                                <td class="rupiah">{{ $anggaran->total }}</td>
                                            </tr>
                                            <?php $totalAnggaran += $anggaran->total; ?>
                                        @endforeach
                                        <tr>
                                            <th colspan="4">Total Anggaran</th>
                                            <th class="rupiah">{{ $totalAnggaran }}</th>
                                            <th></th>
                                        </tr>
                                    </table>
                                @else
                                    <p class="font-italic">Tidak ada anggaran yang ditambahkan</p>
                                @endif
                                <hr>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if (Request::is('admin/rencana-kinerja/*'))
                    <button class="btn btn-danger" id="btn-admin-send-back">
                        <i class="fas fa-undo"></i>
                        Kembalikan
                    </button>
                    @if ($timKerja->status == 2)
                        <button class="btn btn-success" id="btn-admin-submit-rk">
                            <i class="far fa-paper-plane"></i>
                            Ajukan
                        </button>
                    @endif
                @endif
                @if (Request::is('pegawai/rencana-kinerja/*'))
                    @if ($timKerja->status < 2)
                        <button class="btn btn-success"><i class="far fa-paper-plane"></i> Ajukan </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
