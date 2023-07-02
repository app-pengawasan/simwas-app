<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSasaran;
use App\Models\MasterTujuan;
use Illuminate\Support\Facades\Validator;

class MasterSasaranController extends Controller
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

        return view('admin.master-sasaran', [
            'type_menu'     => 'rencana-kinerja',
            'masterTujuan'  => $masterTujuan,
            'masterSasaran' => $masterSasaran,
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
            'tujuan' => 'required',
            'sasaran'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $request->validate($rules);

        MasterSasaran::create([
            'id_tujuan' => $validatedData['tujuan'],
            'sasaran'   => $validatedData['sasaran']
        ]);

        $request->session()->put('status', 'Berhasil menambahkan sasaran Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah sasaran Inspektorat Utama',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterSasaran  $masterSasaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sasaran = MasterSasaran::where('id_sasaran', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Sasaran',
            'data'      => $sasaran
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterSasaran  $masterSasaran
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterSasaran $masterSasaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterSasaran  $masterSasaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'id_sasaran'    => 'required',
            'tujuan'     => 'required',
            'sasaran'       => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        MasterSasaran::where('id_sasaran', $id)
        ->update([
            'id_tujuan' => $validateData['tujuan'],
            'sasaran'   => $validateData['sasaran']
        ]);

        $request->session()->put('status', 'Berhasil memperbarui Sasaran Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterSasaran  $masterSasaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        MasterSasaran::where('id_sasaran', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus Sasaran Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Sasaran Inspektorat Utama',
        ]);
    }
}
