<?php

namespace App\Http\Controllers;

use App\Models\MasterIKU;
use App\Models\MasterTujuan;
use Illuminate\Http\Request;
use App\Models\MasterSasaran;
use Illuminate\Support\Facades\Validator;

class MasterIKUController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterTujuan = MasterTujuan::all();
        $masterSasaran = MasterSasaran::all();
        $masterIku = MasterIKU::all();

        return view('admin.master-iku', [
            'type_menu'     => 'rencana-kinerja',
            'masterTujuan'  => $masterTujuan,
            'masterSasaran'  => $masterSasaran,
            'masterIku'  => $masterIku,
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
            'id_sasaran' => 'required',
            'iku'       => 'required'
        ];

        $validateData = $request->validate($rules);

        MasterIKU::create($validateData);

        return redirect(route('master-iku.index'))->with('success', 'Berhasil menambah Indikator Kinerja Utama Inspektorat Utama.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterIKU  $masterIKU
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $iku = MasterIKU::where('id_iku', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Indikator Kinerja Utama',
            'data'      => $iku
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterIKU  $masterIKU
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterIKU $masterIKU)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterIKU  $masterIKU
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'id_iku'        => 'required',
            'id_sasaran'    => 'required',
            'iku'           => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        MasterIKU::where('id_iku', $id)
        ->update([
            'id_sasaran'     => $request->id_sasaran,
            'iku'            => $request->iku,
        ]);

        // $sasaran = MasterSasaran::where('id_sasaran', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterIKU  $masterIKU
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterIKU::where('id_iku', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Indikator Berhasil Dihapus!',
        ]);
    }
}
