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
            'pelaksana_tugas' => $pelaksana_tugas,
            'realisasi' => $realisasi,
            'year' => $year,
            'unit' => $unit,
            'events' => $events
        ]);
    }

}
