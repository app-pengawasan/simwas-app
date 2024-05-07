<?php

namespace App\Http\Controllers;

use App\Models\Kompetensi;
use App\Models\NormaHasil;
use App\Models\RencanaKerja;
use App\Models\Sl;
use App\Models\StKinerja;
use App\Models\Stp;
use App\Models\Stpd;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\UsulanSuratSrikandi;
use App\Models\TimKerja;

class DashboardController extends Controller
{
    private $kodeHasilPengawasan = [
        "110" => 'LHA',
        "120" => 'LHK',
        "130" => 'LHT',
        "140" => 'LHI',
        "150" => 'LHR',
        "160" => 'LHE',
        "170" => 'LHP',
        "180" => 'LHN',
        "190" => 'LTA',
        "200" => 'LTR',
        "210" => 'LTE',
        "220" => 'LKP',
        "230" => 'LKS',
        "240" => 'LKB',
        "500" => 'EHP',
        "510" => 'LTS',
        "520" => 'PHP',
        "530" => 'QAP'
    ];

    function suratSrikandiCount($year){
        $usulanCount= UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('status', 'usulan')->count();
        $disetujuiCount= UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('status', 'disetujui')->count();
        $ditolakCount= UsulanSuratSrikandi::with('user')->latest()->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->where('status', 'ditolak')->count();

        if ($usulanCount+$disetujuiCount+$ditolakCount != 0) {
            $percentage_usulan = intval($usulanCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
            $percentage_disetujui = intval($disetujuiCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
            $percentage_ditolak = intval($ditolakCount/($usulanCount+$disetujuiCount+$ditolakCount)*100);
        } else
        {
            $percentage_usulan = 0;
            $percentage_disetujui = 0;
            $percentage_ditolak = 0;
        }

        return [
            'percentage_usulan' => $percentage_usulan,
            'percentage_disetujui' => $percentage_disetujui,
            'percentage_ditolak' => $percentage_ditolak,
            'usulanCount' => $usulanCount,
            'disetujuiCount' => $disetujuiCount,
            'ditolakCount' => $ditolakCount,
        ];
    }

    function ketuaTimKerjaCount($year){
        $id_pegawai = auth()->user()->id;
        $timKerjaPenyusunanCount = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->where('status', [0,1,2,3,4])->where('tahun', $year)->get()->count();
        $timKerjaDiajukanCount = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->where('status', 5)->where('tahun', $year)->get()->count();
        $timKerjaDiterimaCount = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->where('status', 6)->where('tahun', $year)->get()->count();

        $timKerjaTotalCount = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->where('tahun', $year)->get()->count();

        $timKerjaPercentagePenyusunan = $timKerjaPenyusunanCount != 0 ? intval($timKerjaPenyusunanCount/($timKerjaTotalCount)*100) : 0;
        $timKerjaPercentageDiajukan = $timKerjaDiajukanCount != 0 ? intval($timKerjaDiajukanCount/($timKerjaTotalCount)*100) : 0;
        $timKerjaPercentageDiterima = $timKerjaDiterimaCount != 0 ? intval($timKerjaDiterimaCount/($timKerjaTotalCount)*100) : 0;


        return [
            'timKerjaTotalCount' => $timKerjaTotalCount,
            'timKerjaPenyusunanCount' => $timKerjaPenyusunanCount,
            'timKerjaDiajukanCount' => $timKerjaDiajukanCount,
            'timKerjaDiterimaCount' => $timKerjaDiterimaCount,
            'timKerjaPercentagePenyusunan' => $timKerjaPercentagePenyusunan,
            'timKerjaPercentageDiajukan' => $timKerjaPercentageDiajukan,
            'timKerjaPercentageDiterima' => $timKerjaPercentageDiterima,
        ];
    }

    function usulanNormaHasilCount($year){
        $usulan = NormaHasil::with('normaHasilAccepted')->where('user_id', auth()->user()->id)->whereYear('created_at', $year)->get();
        $usulanCount = $usulan->count();
        $diperiksaCount = $usulan->where('status_norma_hasil', 'diperiksa')->count();
        $disetujuiCount = $usulan->where('status_norma_hasil', 'disetujui')->count();
        $ditolakCount = $usulan->where('status_norma_hasil', 'ditolak')->count();
        return [
            'usulanCount' => $usulanCount,
            'disetujuiCount' => $disetujuiCount,
            'ditolakCount' => $ditolakCount,
            'diperiksaCount' => $diperiksaCount,

            'percentage_diperiksa' => $diperiksaCount != 0 ? intval($diperiksaCount/($usulanCount)*100) : 0,
            'percentage_disetujui' => $disetujuiCount != 0 ? intval($disetujuiCount/($usulanCount)*100) : 0,
            'percentage_ditolak' => $ditolakCount != 0 ? intval($ditolakCount/($usulanCount)*100) : 0,
        ];

    }



    function pegawai(Request $request) {

        $year = $request->year;
        $id_unitkerja = auth()->user()->unit_kerja;

        // dd($year);

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $suratSrikandiCount = $this->suratSrikandiCount($year);
        $normaHasilCount = $this->usulanNormaHasilCount($year);
        $usulanNormaHasilCount = NormaHasil::with('user', 'normaHasilAccepted')->latest()->whereYear('created_at', $year)->whereHas('rencanaKerja.timkerja', function ($query) {
            $query->where('id_ketua', auth()->user()->id)->where('status_norma_hasil', 'diperiksa');
        })->count();
        $timKerjaCount = $this->ketuaTimKerjaCount($year);
        // dd($timKerjaCount);
        $usulanPimpinanCount = TimKerja::with(['ketua', 'iku'])
            ->where('unitkerja', $id_unitkerja)
            ->whereIn('status', [5])
            ->where('tahun', $year)
            ->count();

        return view('pegawai.index', [
            'type_menu' => 'usulan-surat-srikandi',
            'percentage_usulan' => $suratSrikandiCount['percentage_usulan'],
            'percentage_disetujui' => $suratSrikandiCount['percentage_disetujui'],
            'percentage_ditolak' => $suratSrikandiCount['percentage_ditolak'],
            'total_usulan' => $suratSrikandiCount['usulanCount'],
            'usulanCount' => $suratSrikandiCount['usulanCount'],
            'disetujuiCount' => $suratSrikandiCount['disetujuiCount'],
            'ditolakCount' => $suratSrikandiCount['ditolakCount'],

            'normaHasilCount' => $normaHasilCount['usulanCount'],
            'normaHasilDisetujui' => $normaHasilCount['disetujuiCount'],
            'normaHasilDitolak' => $normaHasilCount['ditolakCount'],
            'normaHasilDiperiksa' => $normaHasilCount['diperiksaCount'],
            'normaHasilPercentageDiperiksa' => $normaHasilCount['percentage_diperiksa'],
            'normaHasilPercentageDisetujui' => $normaHasilCount['percentage_disetujui'],
            'normaHasilPercentageDitolak' => $normaHasilCount['percentage_ditolak'],

            'usulanNormaHasilCount' => $usulanNormaHasilCount,

            'timKerjaTotalCount' => $timKerjaCount['timKerjaTotalCount'],
            'timKerjaPenyusunanCount' => $timKerjaCount['timKerjaPenyusunanCount'],
            'timKerjaDiajukanCount' => $timKerjaCount['timKerjaDiajukanCount'],
            'timKerjaDiterimaCount' => $timKerjaCount['timKerjaDiterimaCount'],
            'timKerjaPercentagePenyusunan' => $timKerjaCount['timKerjaPercentagePenyusunan'],
            'timKerjaPercentageDiajukan' => $timKerjaCount['timKerjaPercentageDiajukan'],
            'timKerjaPercentageDiterima' => $timKerjaCount['timKerjaPercentageDiterima'],

            'usulanPimpinanCount' => $usulanPimpinanCount,



        ]);
    }

    function sekretaris() {
        $this->authorize('sekretaris');
        $usulanSuratSrikandi = UsulanSuratSrikandi::latest()->where('status', 'usulan')->count();
        $nh = NormaHasil::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $us = Sl::where('unit_kerja', auth()->user()->unit_kerja)->count();

        return view('sekretaris.index', [
            "nh" => $nh,
            "us" => $us,
            "usulanCount" => $usulanSuratSrikandi

        ]);
    }

    function inspektur() {
        $this->authorize('inspektur');
        // $stk = StKinerja::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stk_sum = StKinerja::whereHas('rencanaKerja.proyek.timkerja', function ($query) {
            $query->where('unitkerja', auth()->user()->unit_kerja);
        })->count();
        $stk_need_approval = StKinerja::where('status', 0)->whereHas('rencanaKerja.proyek.timkerja', function ($query) {
            $query->where('unitkerja', auth()->user()->unit_kerja);
        })->count();
        $stp_sum = Stp::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stp_need_approval = Stp::where('status', 3)->where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stpd_sum = Stpd::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stpd_need_approval = Stpd::where('status', 0)->where('unit_kerja', auth()->user()->unit_kerja)->count();


        return view('inspektur.index', [
            "stk_sum" => $stk_sum,
            "stk_need_approval" => $stk_need_approval,
            "stp_sum" => $stp_sum,
            "stp_need_approval" => $stp_need_approval,
            "stpd_sum" => $stpd_sum,
            "stpd_need_approval" => $stpd_need_approval
        ]);
    }

    function analis_sdm() {
        $this->authorize('analis_sdm');
        $pegawai = User::all();
        $kompetensi = Kompetensi::where('status', 1)->get();
        $count = $kompetensi->groupBy('pegawai_id')->map->countBy('pp_id');

        return view('analis-sdm.index', [
            'pegawai' => $pegawai,
            'kompetensi' => $kompetensi,
            'count' => $count
        ]);
    }

    function perencana() {
        $this->authorize('perencana');
        return view('perencana.index', [
            'type_menu' => 'rencana-kerja'
        ]);
    }

    function arsiparis() {
        $this->authorize('arsiparis');
        $tugas = RencanaKerja::get();
        return view('arsiparis.index', [
            'tugas' => $tugas,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
        ]);
    }
}
