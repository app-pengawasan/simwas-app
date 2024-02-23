<?php

namespace App\Http\Controllers;

use App\Models\Kompetensi;
use App\Models\NormaHasil;
use App\Models\Sl;
use App\Models\StKinerja;
use App\Models\Stp;
use App\Models\Stpd;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class DashboardController extends Controller
{
    function pegawai() {
        $stk = StKinerja::where('user_id', auth()->user()->id)->count();
        $stp = Stp::where('user_id', auth()->user()->id)->count();
        $stpd = Stpd::where('user_id', auth()->user()->id)->count();
        $sl = Sl::where('user_id', auth()->user()->id)->count();
        $surat = Surat::latest()->where('user_id', auth()->user()->id)->get();

        return view('pegawai.index', [
            "stk" => $stk,
            "stp" => $stp,
            "stpd" => $stpd,
            "sl" => $sl
        ])->with('surat', $surat);
    }

    function sekretaris() {
        $this->authorize('sekretaris');
        $nh = NormaHasil::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $us = Sl::where('unit_kerja', auth()->user()->unit_kerja)->count();

        return view('sekretaris.index', [
            "nh" => $nh,
            "us" => $us
        ]);
    }

    function inspektur() {
        $this->authorize('inspektur');
        // $stk = StKinerja::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stk_sum = StKinerja::whereHas('rencanaKerja.timkerja', function ($query) {
            $query->where('unitkerja', auth()->user()->unit_kerja);
        })->count();
        $stk_need_approval = StKinerja::where('status', 0)->whereHas('rencanaKerja.timkerja', function ($query) {
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
}
