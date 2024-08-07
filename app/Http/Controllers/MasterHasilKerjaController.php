<?php

namespace App\Http\Controllers;

use App\Models\MasterHasilKerja;
use App\Http\Requests\StoreMasterHasilKerjaRequest;
use App\Http\Requests\UpdateMasterHasilKerjaRequest;
use App\Models\MasterUnsur;
use App\Models\MasterSubUnsur;

class MasterHasilKerjaController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');

        $masterHasilKerjas = MasterHasilKerja::with('masterSubUnsur','masterKinerja')->latest()->get();
        $masterSubUnsurs = MasterSubUnsur::all();
        $masterUnsurs = MasterUnsur::all();
        return view('admin.master-hasil-kerja.index', [
            'type_menu' => 'rencana-kinerja',
            'masterSubUnsurs' => $masterSubUnsurs,
            'masterUnsurs' => $masterUnsurs,
            'masterHasilKerjas' => $masterHasilKerjas,
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
     * @param  \App\Http\Requests\StoreMasterHasilKerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterHasilKerjaRequest $request)
    {
        try {
            MasterHasilKerja::create([
                'master_subunsur_id' => $request->masterSubUnsurId,
                'nama_hasil_kerja' => $request->namaHasilKerja,
                'kategori_pelaksana' => $request->status == '1' ? 'gt' : 'ngt',
            ]);
            return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data gagal ditambahkan, data sudah ada')->with('alert-type', 'danger');
            } else {
            return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data gagal ditambahkan, Periksa lagi data anda')->with('alert-type', 'danger');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterHasilKerja  $masterHasilKerja
     * @return \Illuminate\Http\Response
     */
    public function show(MasterHasilKerja $masterHasilKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterHasilKerja  $masterHasilKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterHasilKerja $masterHasilKerja)
    {
        // return json
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterHasilKerjaRequest  $request
     * @param  \App\Models\MasterHasilKerja  $masterHasilKerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterHasilKerjaRequest $request, MasterHasilKerja $masterHasilKerja)
    {
        try {
            $masterHasilKerja->update([
                'master_subunsur_id' => $request->editMasterSubUnsurId,
                'nama_hasil_kerja' => $request->editNamaHasilKerja,
                'kategori_pelaksana' => $request->editStatus == '1' ? 'gt' : 'ngt',
            ]);
            return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data gagal diubah, data sudah ada')->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data gagal diubah, silakan periksa data lagi')->with('alert-type', 'danger');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterHasilKerja  $masterHasilKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterHasilKerja $masterHasilKerja)
    {
        try {
            $masterHasilKerja->delete();
        return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1451) {
                return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data gagal dihapus, data masih digunakan')->with('alert-type', 'danger');
            }
            return redirect()->route('admin.master-hasil-kerja.index')->with('status', 'Data gagal dihapus')->with('alert-type', 'danger');
        }

    }

    public function showMasterHasilKerja($id)
    {
        try {
            $masterHasilKerja = MasterHasilKerja::find($id);
            $masterHasilKerja->masterSubUnsurName = MasterSubUnsur::find($masterHasilKerja->master_subunsur_id)->nama_sub_unsur;
            $masterHasilKerja->masterUnsurName = MasterUnsur::find(MasterSubUnsur::find($masterHasilKerja->master_subunsur_id)->master_unsur_id)->nama_unsur;
            $masterHasilKerja->masterUnsurId = MasterSubUnsur::find($masterHasilKerja->master_subunsur_id)->master_unsur_id;
            return response()->json($masterHasilKerja);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
}
