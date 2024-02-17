<?php

namespace App\Http\Controllers;

use App\Models\MasterSubUnsur;
use App\Models\MasterUnsur;
use App\Http\Requests\StoreMasterUnsurRequest;
use App\Http\Requests\UpdateMasterUnsurRequest;

class MasterUnsurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterUnsurs = MasterUnsur::all();
        return view('admin.master-unsur.index', [
            'type_menu' => 'rencana-kinerja',
            'masterUnsurs' => $masterUnsurs,
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
     * @param  \App\Http\Requests\StoreMasterUnsurRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterUnsurRequest $request)
    {

        MasterUnsur::create([
            'nama_unsur' => $request->namaUnsur,
        ]);
        return redirect()->route('master-unsur.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterUnsur  $masterUnsur
     * @return \Illuminate\Http\Response
     */
    public function show(MasterUnsur $masterUnsur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterUnsur  $masterUnsur
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterUnsur $masterUnsur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterUnsurRequest  $request
     * @param  \App\Models\MasterUnsur  $masterUnsur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterUnsurRequest $request, MasterUnsur $masterUnsur)
    {
        $masterUnsur->update([
            'nama_unsur' => $request->editNamaUnsur,
        ]);
        return redirect()->route('master-unsur.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterUnsur  $masterUnsur
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterUnsur $masterUnsur)
    {
        $masterUnsur->delete();
        return redirect()->route('master-unsur.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
    }

    public function getUnsurBySubUnsur($id)
    {
        $unsur = MasterSubUnsur::where('id', $id)->first()->masterUnsur;
        return response()->json($unsur);
    }
}
