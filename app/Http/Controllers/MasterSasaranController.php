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
            'id_tujuan' => 'required',
            'sasaran'   => 'required',
        ];

        $validatedData = $request->validate($rules);

        MasterSasaran::create($validatedData);
        return redirect(route('master-sasaran.index'))->with('success', 'Berhasil menambah sasaran Inspektorat Utama.');
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
            'id_tujuan'     => 'required',
            'sasaran'       => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        MasterSasaran::where('id_sasaran', $id)
        ->update([
            'id_tujuan' => $request->id_tujuan,
            'sasaran'        => $request->sasaran,
        ]);

        $sasaran = MasterSasaran::where('id_sasaran', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $sasaran
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterSasaran  $masterSasaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterSasaran::where('id_sasaran', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sasaran Berhasil Dihapus!',
        ]);
    }
}
