<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TimKerja;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use App\Models\LaporanObjekPengawasan;
use Illuminate\Database\Eloquent\Builder;

class MonitoringPegawaiController extends Controller
{
    public function admin(Request $request)
    {
        $this->authorize('admin');

        $year = TimKerja::select('tahun')->distinct()->orderBy('tahun', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('tahun')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['tahun' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('tahun');
        $unit = auth()->user()->unit_kerja;
         
        return view('admin.kinerja-pegawai', [
            'type_menu' => 'kinerja-pegawai',
            // 'pelaksana_tugas' => $pelaksana_tugas,
            // 'realisasi' => $realisasi,
            'year' => $year,
            'unit' => $unit,
            // 'events' => $events
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                       
            $unit = $request->unit;
            if ($unit == null || $unit == "undefined") {
                if (auth()->user()->unit_kerja == '8010') $unit = '8000';
                else $unit = auth()->user()->unit_kerja;
            } else {
                if (auth()->user()->unit_kerja != '8010' && auth()->user()->unit_kerja != '8000' && $unit != auth()->user()->unit_kerja)
                    return redirect()->to('/');
            }

            $year = $request->year;
            if ($year == null) {
                $year = date('Y');
            } 

            if ($unit == '8000') {
                $pelaksana_tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year, $unit) {
                                            $query->where('tahun', $year);
                                    })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')->get();
            } else {
                $pelaksana_tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year, $unit) {
                                            $query->where('tahun', $year);
                                            $query->where('unitkerja', $unit);
                                    })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan')->get();
            }

            $realisasi = RealisasiKinerja::whereRelation('pelaksana.rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                                    $query->where('tahun', $year);
                                            })->get();

            $events = Event::whereRelation('laporanOPengawasan.objekPengawasan.rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                    $query->where('tahun', $year);
                            })->get();
            
            $data = array(); $count = 0;

            foreach ($pelaksana_tugas as $pelaksana) {
                if (count($pelaksana->rencanaKerja->objekPengawasan) > 0) {
                    foreach ($pelaksana->rencanaKerja->objekPengawasan as $oPengawasan) {
                        foreach ($oPengawasan->laporanObjekPengawasan->where('status', 1) as $laporanObjek) {
                            $row    = array(); $count++;
                            $row['tim']  = $pelaksana->rencanaKerja->proyek->timKerja->nama;
                            $row['pjk']  = $pelaksana->rencanaKerja->proyek->timKerja->ketua->name;
                            $row['tugas']  = $pelaksana->rencanaKerja->tugas;
                            $row['nama']  = $pelaksana->user->name;
                            $row['output']  = count($pelaksana->rencanaKerja->hasilKerja->masterKinerja) == 0 ? 'Belum diisi' : 
                                        $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first()->hasil_kerja;
                            $row['objek']  = $oPengawasan->nama;
                            $row['bulanTarget']  = $bulan[$laporanObjek->month - 1];
                            if ($realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                            ->where('id_laporan_objek', $laporanObjek->id)->first() != null) {
                                $dokumen = $realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                                        ->where('id_laporan_objek', $laporanObjek->id)->first();
                                if ($dokumen->status == 1) {
                                    $row['statusDok'] = '<a href="'.$dokumen->hasil_kerja.'" target="_blank">
                                                <div class="badge badge-success">Sudah Masuk</div>
                                              </a>';
                                } elseif ($dokumen->status == 2) {
                                    $row['statusDok'] = '<div class="badge badge-danger">Dibatalkan</div>';
                                } else {
                                    $row['statusDok'] = '<div class="badge badge-dark">Tidak Selesai</div>';
                                }
                            } else {
                                unset($dokumen);
                                $row['statusDok'] = '<div class="badge badge-warning">Belum Masuk</div>';
                            }
                            $row['bulanReal'] = (isset($dokumen) && $dokumen->status == 1) ? $bulan[date("n",strtotime($dokumen->tgl_upload)) - 1] : '';
                            if (isset($dokumen) && $dokumen->status == 1) {
                                $targetthn = $year ?? date('Y');
                                $targetbln = $targetthn.'-'.sprintf('%02d', $laporanObjek->month).'-01';
                                $realisasibln = date("Y-m",strtotime($dokumen->tgl_upload)).'-01';
                                if ($realisasibln < $targetbln) $row['status'] = 'Lebih Cepat';
                                elseif ($realisasibln == $targetbln) $row['status'] = 'Tepat Waktu';
                                else $row['status'] = 'Terlambat';
                            } else $row['status'] = '';
                            $row['rencanaJam'] = $pelaksana->jam_pengawasan;
                            $total_jam = 0; 
                            foreach ($events->where('laporan_opengawasan', $laporanObjek->id)
                                            ->where('id_pegawai', $pelaksana->id_pegawai) as $event) {
                                $start = $event->start;
                                $end = $event->end;
                                $total_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                            }
                            $row['realJam'] = $total_jam;
                            $row['hasilTim'] = $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja;
                            $row['subunsur'] = $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur;
                            $row['unsur'] = $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur;
                            $row['iku'] = $pelaksana->rencanaKerja->proyek->timKerja->iku->iku;
                            $data[] = $row;
                        }
                    }
                } else {
                    $row    = array(); $count++;
                    $row['tim']  = $pelaksana->rencanaKerja->proyek->timKerja->nama;
                    $row['pjk']  = $pelaksana->rencanaKerja->proyek->timKerja->ketua->name;
                    $row['tugas']  = $pelaksana->rencanaKerja->tugas;
                    $row['nama']  = $pelaksana->user->name;
                    $row['output']  = count($pelaksana->rencanaKerja->hasilKerja->masterKinerja) == 0 ? 'Belum diisi' : 
                                $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first()->hasil_kerja;
                    $row['objek']  = '';
                    $row['bulanTarget']  = '';
                    $row['statusDok']  = '<div class="badge badge-warning">Belum Masuk</div>';
                    $row['bulanReal']  = '';
                    $row['status']  = '';
                    $row['rencanaJam']  = $pelaksana->jam_pengawasan;
                    $row['realJam']  = 0;
                    $row['hasilTim'] = $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja;
                    $row['subunsur'] = $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur;
                    $row['unsur'] = $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur;
                    $row['iku'] = $pelaksana->rencanaKerja->proyek->timKerja->iku->iku;
                    $data[] = $row;
                }
            } 
            
            $output = array(
                "draw"              => $_POST['draw'],
                "recordsTotal"      => $count,
                "recordsFiltered"   => $count,
                "data"              => array_slice($data, $_POST['start'], $_POST['length']),
            );

            return $output;
        }
    }
}
