<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\MasterHasil;
use App\Http\Requests\StoreProyekRequest;
use App\Http\Requests\UpdateProyekRequest;
use App\Models\MasterHasilKerja;

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
            ]);
            $request->session()->put('status', 'Berhasil menambahkan Proyek');
        $request->session()->put('alert-type', 'success');
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
        $timKerja = $proyek->timKerja;
        $masterHasil = MasterHasilKerja::all();
        $rencanaKerjas = $proyek->rencanaKerja;

        return view('pegawai.rencana-kinerja.proyek.show', [
            'proyek' => $proyek,
            'timKerja' => $timKerja,
            'masterHasil' => $masterHasil,
            'rencanaKerjas' => $rencanaKerjas,
            'type_menu' => 'rencana-kinerja'
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
    public function update($id)
    {
        try {
            $proyek = Proyek::where('id', $id)->first();
            $proyek->update([
                'nama_proyek' => request()->input('nama_proyek'),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah Proyek',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyek $proyek)
    {
        try {
            $proyek->delete();
            // return back
            return redirect()->back()->with('status', 'Berhasil Menghapus Proyek')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('status', 'Gagal Menghapus Proyek, Data masih digunakan di tugas')
                ->with('alert-type', 'danger');
        }
    }
}
