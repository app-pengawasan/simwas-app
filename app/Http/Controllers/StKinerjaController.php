<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Http\Requests\StoreStKinerjaRequest;
use App\Http\Requests\UpdateStKinerjaRequest;

class StKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = '';

        return view('pegawai.st-kinerja.index', [
            "title" => "Surat Tugas Kinerja" . $title,
            "type_menu" => "surat-saya"
            // "usulan" => UsulanNomor::all()
            //"usulan" => STK::latest()->filter(request(['search']))->paginate(5)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStKinerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStKinerjaRequest $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'rencana_id' => 'required',
            'unit-kerja' => 'required',
            'tim-kerja' => 'required',
            'tugas' => 'required',
            'melaksanakan' => 'required',
            'objek' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'dalnis' => 'required',
            'ketua' => 'required',
            'anggota' => 'required',
            'penandatangan' => 'required',
            'status' => 'required',
            'no_st' => 'required',
            'is_esign' => 'required',
        ],[
            'after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
            'required' => 'Wajib diisi.',
            'unit-kerja.required' => 'Mohon pilih salah satu unit kerja.',
            'tim-kerja.required' => 'Mohon pilih salah satu tim kerja.',
            'tugas.required' => 'Mohon pilih salah satu tugas.',
            'penandatangan.required' => 'Mohon pilih salah satu penandatangan.'
        ]);

        StKinerja::create($validatedData);

        return redirect('/pegawai/st-kinerja')->with('success', 'Pengajuan ST Kinerja berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function show(StKinerja $stKinerja)
    {
        return view('pegawai.st-kinerja.show', [
            "title" => "Detail Usulan Surat Tugas Kinerja",
            "usulan" => $stKinerja
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function edit(StKinerja $stKinerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStKinerjaRequest  $request
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStKinerjaRequest $request, StKinerja $stKinerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(StKinerja $stKinerja)
    {
        //
    }

    public function form()
    {
        return view('pegawai.st-kinerja.form', [
            "title" => "Ajukan Usulan Surat Tugas Kinerja",
        ]);
    }
}
