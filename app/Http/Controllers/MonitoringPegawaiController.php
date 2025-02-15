<?php

namespace App\Http\Controllers;

use App\Models\LaporanObjekPengawasan;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class MonitoringPegawaiController extends Controller
{

    public function admin(Request $request)
    {
        $this->authorize('admin');

        $year = $request->year;
        if ($year == null) {
            $year = date('Y');
        } 

        $pelaksana_tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                $query->where('tahun', $year);
                        })->get();

        $realisasi = RealisasiKinerja::all();
         
        return view('admin.kinerja-pegawai', [
            'type_menu' => 'kinerja-pegawai',
            'pelaksana_tugas' => $pelaksana_tugas,
            'realisasi' => $realisasi,
        ]);
    }

}
