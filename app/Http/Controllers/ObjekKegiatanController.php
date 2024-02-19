<?php

namespace App\Http\Controllers;

use App\Models\MasterObjek;
use App\Models\MasterUnitKerja;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;
use App\Models\ObjekKegiatan;
use Illuminate\Support\Facades\Validator;

class ObjekKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');

        $masterUnitKerja = MasterUnitKerja::where('kategori', 1)->get();
        $masterObjekKegiatan = ObjekKegiatan::where('is_active', 1)->get();

        return view('admin.master-objek.objek-kegiatan', [
            'type_menu'         => 'objek',
            'master_unitkerja'    => $masterUnitKerja,
            'master_objekkegiatan'  => $masterObjekKegiatan
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_unitkerja'    => 'required',
            'unit_kerja'        => 'required',
            'kode_kegiatan'     => 'required|unique:objek_kegiatans,kode_kegiatan',
            'nama'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = request()->validate($rules);
        ObjekKegiatan::create([
            'nama_unitkerja'    => $validateData['nama_unitkerja'],
            'kode_unitkerja'    => $validateData['unit_kerja'],
            'kode_kegiatan'     => $validateData['kode_kegiatan'],
            'nama'              => $validateData['nama']
        ]);

        $request->session()->put('status', 'Berhasil menambahkan kegiatan Unit Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah data kegiatan Unit Kerja',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($kodekegiatan)
    {
        $objekKegiatan = ObjekKegiatan::where('kode_kegiatan', $kodekegiatan)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Data Satuan Kerja',
            'data'      => $objekKegiatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(ObjekKegiatan $objekKegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objekKegiatan = ObjekKegiatan::where('kode_kegiatan', $id)->get();

        $rules = [
            'nama_unitkerja'    => 'required',
            'kode_unitkerja'    => 'required',
            'nama'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        ObjekKegiatan::where('kode_kegiatan', $id)
        ->update([
            'nama_unitkerja'    => $request->nama_unitkerja,
            'kode_unitkerja'    => $request->kode_unitkerja,
            'nama'              => $request->nama
        ]);

        $objekKegiatan = ObjekKegiatan::where('kode_kegiatan', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $objekKegiatan
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        ObjekKegiatan::where('kode_kegiatan', $id)
        ->update([
            'is_active' => 0
        ]);

        $request->session()->put('status', 'Berhasil menghapus kegiatan Unit Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Dihapus',
        ]);
    }

    public function unitkerja($id){
        $count = ObjekKegiatan::where('kode_unitkerja', $id)->count();

        return response()->json([
            'success'   => true,
            'message'   => 'Jumlah Kegiatan Unit kerja '.$id,
            'data'      => [
                'count' => $count
                ]
        ]);
    }

    public function objekByKategori($id){
        if($id == 4){
            $objek = ObjekKegiatan::all();
        }else{
            $objek = MasterObjek::where('kategori', $id)->get();
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Daftar Objek by Kategori',
            'data'      => $objek
        ]);
    }
}
