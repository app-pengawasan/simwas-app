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

    function pegawai() {
        // $stk = StKinerja::where('user_id', auth()->user()->id)->count();
        // $stp = Stp::where('user_id', auth()->user()->id)->count();
        // $stpd = Stpd::where('user_id', auth()->user()->id)->count();
        // $sl = Sl::where('user_id', auth()->user()->id)->count();
        // $surat = Surat::latest()->where('user_id', auth()->user()->id)->get();

        // return view('pegawai.index', [
        //     "stk" => $stk,
        //     "stp" => $stp,
        //     "stpd" => $stpd,
        //     "sl" => $sl
        // ])->with('surat', $surat);
        $year = request('year');
        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
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

        return view('pegawai.index', [
            'type_menu' => 'usulan-surat-srikandi',
            'percentage_usulan' => $percentage_usulan,
            'percentage_disetujui' => $percentage_disetujui,
            'percentage_ditolak' => $percentage_ditolak,
            'total_usulan' => $usulanCount + $disetujuiCount + $ditolakCount,
            'usulanCount' => $usulanCount,
            'disetujuiCount' => $disetujuiCount,
            'ditolakCount' => $ditolakCount,
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
