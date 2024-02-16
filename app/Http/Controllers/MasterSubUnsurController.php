<?php

namespace App\Http\Controllers;

use App\Models\MasterSubUnsur;
use App\Http\Requests\StoreMasterSubUnsurRequest;
use App\Http\Requests\UpdateMasterSubUnsurRequest;
use App\Models\MasterUnsur;

class MasterSubUnsurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterSubUnsurs = MasterSubUnsur::all();
        $masterUnsurs = MasterUnsur::all();
        foreach ($masterSubUnsurs as $key => $masterSubUnsur) {
            $masterSubUnsur->master_unsur_name = $masterUnsurs->where('id', $masterSubUnsur->master_unsur_id)->first()->nama_unsur;
        }
        return view('admin.master-subunsur.index', [
            'type_menu' => 'rencana-kinerja',
            'masterSubUnsurs' => $masterSubUnsurs,
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
     * @param  \App\Http\Requests\StoreMasterSubUnsurRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterSubUnsurRequest $request)
    {
        // dd($request->all());
        MasterSubUnsur::create([
            'master_unsur_id' => $request->masterUnsurId,
            'nama_sub_unsur' => $request->namaSubUnsur,
        ]);
        return redirect()->route('master-subunsur.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterSubUnsur  $masterSubUnsur
     * @return \Illuminate\Http\Response
     */
    public function show(MasterSubUnsur $masterSubUnsur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterSubUnsur  $masterSubUnsur
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterSubUnsur $masterSubUnsur)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterSubUnsurRequest  $request
     * @param  \App\Models\MasterSubUnsur  $masterSubUnsur
     * @return \Illuminate\Http\Response
     */
    public function update($masterSubUnsur)
    {
        MasterSubUnsur::where('id', $masterSubUnsur)->update([
            'master_unsur_id' => request()->editMasterUnsurId,
            'nama_sub_unsur' => request()->editNamaSubUnsur,
        ]);
        return(redirect()->route('master-subunsur.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterSubUnsur  $masterSubUnsur
     * @return \Illuminate\Http\Response
     */
    public function destroy($masterSubUnsur)
    {
        MasterSubUnsur::destroy($masterSubUnsur);
        return redirect()->route('master-subunsur.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
    }
    // api request
    public function getSubUnsurByUnsur($id)
    {
        $masterSubUnsurs = MasterSubUnsur::where('master_unsur_id', $id)->get();
        return response()->json($masterSubUnsurs);
    }
}
