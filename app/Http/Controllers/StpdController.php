<?php

namespace App\Http\Controllers;

use App\Models\Stpd;
use App\Models\StKinerja;
use App\Models\User;
use App\Models\MasterPimpinan;
use App\Http\Requests\StoreStpdRequest;
use App\Http\Requests\UpdateStpdRequest;
use App\Models\Pembebanan;

class StpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulan = Stpd::latest()->where('user_id', auth()->user()->id)->get();
        return view('pegawai.st-pd.index')->with('usulan', $usulan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->get();
        $pembebanans = Pembebanan::all();
        return view('pegawai.st-pd.create', [
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "stks" => $stks,
            "pembebanans" => $pembebanans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStpdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStpdRequest $request)
    {
        $validatedData = $request->validate([
            'is_backdate' => 'required',
            'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
            'unit_kerja' => 'required',
            'is_st_kinerja' => 'required',
            'melaksanakan' => 'required',
            'kota' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'pelaksana' => 'required',
            'pembebanan' => 'required',
            'penandatangan' => 'required',
            'status' => 'required',
            'is_esign' => 'required'
        ],[
            'after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
            'required' => 'Wajib diisi.'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['pelaksana'] = implode(', ', $validatedData['pelaksana']);
        
        Stpd::create($validatedData);

        return redirect('/pegawai/st-pd')->with('success', 'Pengajuan ST Perjalanan Dinas berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function show(Stpd $stpd)
    {
        return view('pegawai.stpd.stpd_detail', [
            "title" => "Detail Usulan Surat Tugas Perjalanan Dinas",
            "usulan" => $stpd
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function edit(Stpd $stpd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStpdRequest  $request
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStpdRequest $request, Stpd $stpd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stpd $stpd)
    {
        //
    }

    public function form_stpd()
    {
        return view('pegawai.stpd.stpd_form', [
            "title" => "Form Surat Tugas Perjalanan Dinas"
        ]);
    }
}
