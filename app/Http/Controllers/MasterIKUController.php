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
            'sasaran' => 'required',
            'iku'       => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        MasterIKU::create([
            'id_sasaran' => $validateData['sasaran'],
            'iku'        => $validateData['iku']
        ]);


        $request->session()->put('status', 'Berhasil menambahkan IKU Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah IKU Inspektorat Utama',
        ]);
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
            'sasaran'    => 'required',
            'iku'           => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        MasterIKU::where('id_iku', $id)
        ->update([
            'id_sasaran'     => $request->sasaran,
            'iku'            => $request->iku,
        ]);


        $request->session()->put('status', 'Berhasil memperbarui IKU Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

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
    public function destroy(Request $request, $id)
    {
        MasterIKU::where('id_iku', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus IKU Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus IKu Inspektorat Utama',
        ]);
    }
}
