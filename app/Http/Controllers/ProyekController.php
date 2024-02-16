<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Http\Requests\StoreProyekRequest;
use App\Http\Requests\UpdateProyekRequest;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreProyekRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProyekRequest $request)
    {
        try {
            Proyek::create([
                'id_tim_kerja' => $request->id_timkerja,
                'nama_proyek' => $request->nama_proyek,
                'rencana_kinerja_anggota' => $request->rk_anggota,
                'iki_anggota' => $request->iki_anggota,
            ]);
            return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan Proyek',
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(Proyek $proyek)
    {
        $proyek = Proyek::where('id', $proyek->id)->first();
        return view('pegawai.rencana-kinerja.proyek.show', [
            'proyek' => $proyek,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyek $proyek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProyekRequest  $request
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProyekRequest $request, Proyek $proyek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyek $proyek)
    {
        //
    }
}
