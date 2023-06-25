<?php

namespace App\Http\Controllers;

use App\Models\NormaHasil;
use App\Models\Sl;
use App\Models\StKinerja;
use App\Models\Stp;
use App\Models\Stpd;
use App\Models\Surat;
use Illuminate\Http\Request;

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
        $stk = StKinerja::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stp = Stp::where('unit_kerja', auth()->user()->unit_kerja)->count();
        $stpd = Stpd::where('unit_kerja', auth()->user()->unit_kerja)->count();

        return view('inspektur.index', [
            "stk" => $stk,
            "stp" => $stp,
            "stpd" => $stpd
        ]);
    }
}
