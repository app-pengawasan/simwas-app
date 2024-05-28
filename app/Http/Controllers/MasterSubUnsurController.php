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
        $this->authorize('admin');

        $masterSubUnsurs = MasterSubUnsur::with('masterUnsur')->latest()->get();
        $masterUnsurs = MasterUnsur::all();
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
        try {
            MasterSubUnsur::create([
                'master_unsur_id' => $request->masterUnsurId,
                'nama_sub_unsur' => $request->namaSubUnsur,
            ]);
            return redirect()->route('master-subunsur.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('master-subunsur.index')->with('status', 'Data gagal ditambahkan, nama subunsur sudah ada')->with('alert-type', 'danger');
            } else {
                return redirect()->route('master-subunsur.index')->with('status', 'Data gagal ditambahkan')->with('alert-type', 'danger');
            }
        }
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
        try {
            MasterSubUnsur::where('id', $masterSubUnsur)->update([
                'master_unsur_id' => request()->editMasterUnsurId,
                'nama_sub_unsur' => request()->editNamaSubUnsur,
            ]);
            return(redirect()->route('master-subunsur.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success'));
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('master-subunsur.index')->with('status', 'Data gagal diubah, nama subunsur sudah ada')->with('alert-type', 'danger');
            } else {
                return redirect()->route('master-subunsur.index')->with('status', 'Data gagal diubah')->with('alert-type', 'danger');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterSubUnsur  $masterSubUnsur
     * @return \Illuminate\Http\Response
     */
    public function destroy($masterSubUnsur)
    {
        try {
            MasterSubUnsur::destroy($masterSubUnsur);
            return redirect()->route('master-subunsur.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
        } catch (\Exception $e) {
            return redirect()->route('master-subunsur.index')->with('status', 'Data gagal dihapus, data masih digunakan')->with('alert-type', 'danger');
        }
    }
    // api request
    public function getSubUnsurByUnsur($id)
    {
        $masterSubUnsurs = MasterSubUnsur::where('master_unsur_id', $id)->get();
        return response()->json($masterSubUnsurs);
    }
}
