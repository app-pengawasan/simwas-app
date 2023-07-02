<?php

namespace App\Http\Controllers;

use App\Models\ObjekPengawasan;
use App\Models\PelaksanaTugas;
use App\Models\RencanaKerja;
use App\Models\TimKerja;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function getRencanaKerja(Request $request) {
        $id_rencanakerja = $request->input('rencana_id');

        $rencana_kerja = RencanaKerja::where('id_rencanakerja', $id_rencanakerja)->first();
        $tim_kerja = TimKerja::where('id_timkerja', $rencana_kerja->id_timkerja)->first();
        $objek_pengawasan = ObjekPengawasan::where('id_rencanakerja', $rencana_kerja->id_rencanakerja)->get();
        $pelaksana_tugas = PelaksanaTugas::where('id_rencanakerja', $rencana_kerja->id_rencanakerja)->get();
        $dalnis = '';
        $ketua = '';
        $pic = '';
        $anggota = [];
        $counter = 1;
        foreach ($pelaksana_tugas as $pel) {
            if ($pel->pt_jabatan == 1) {
                $dalnis = 'Pengendali Teknis : ['.$pel->user->nip.'] '.$pel->user->name;
            } elseif ($pel->pt_jabatan == 2) {
                $ketua = 'Ketua Tim : ['.$pel->user->nip.'] '.$pel->user->name;
            } elseif ($pel->pt_jabatan == 3) {
                $pic = 'PIC : ['.$pel->user->nip.'] '.$pel->user->name;
            } elseif($pel->pt_jabatan == 4) {
                $anggota[] = 'Anggota '.$counter.' : ['.$pel->user->nip.'] '.$pel->user->name;
                $counter++;
            }
        }
        return response()->json([
            'tim_kerja' => $tim_kerja,
            'objek_pengawasan' => $objek_pengawasan,
            'dalnis' => $dalnis,
            'ketua' => $ketua,
            'pic' => $pic,
            'anggota' => $anggota
        ]);
    }
}
