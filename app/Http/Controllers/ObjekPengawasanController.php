<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjekPengawasan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObjekPengawasanController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'id_rencanakerja'   => 'required',
            'id_objek'          => 'required',
            'kategori_objek'    => 'required',
            'nama'              => 'required'
        ];

        $validateData = $request->validate($rules);

        ObjekPengawasan::create($validateData);

        return response()->json([
            'success'   => true,
            'message'   => 'Objek Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function show(ObjekPengawasan $objekPengawasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function edit(ObjekPengawasan $objekPengawasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'id_objek'          => 'required',
            'kategori'          => 'required',
            'nama'              => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        ObjekPengawasan::where('id_opengawasan', $request->id_opengawasan)
        ->update([
            'id_objek'          => $request->id_objek,
            'kategori_objek'    => $request->kategori,
            'nama'              => $request->nama
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Objek Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ObjekPengawasan::where('id_opengawasan', $id)->delete()   ;

        return response()->json([
            'success'   => true,
            'message'   => 'Objek Berhasil Dihapus'
        ]);
    }
}
