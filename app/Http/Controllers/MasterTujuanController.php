<?php

namespace App\Http\Controllers;

use App\Models\MasterTujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterTujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterTujuan = MasterTujuan::all();

        return view('admin.master-tujuan', [
            'type_menu'     => 'rencana-kinerja',
            'masterTujuan'  => $masterTujuan
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
            'tahun_mulai'   => 'required',
            'tahun_selesai' => 'required|after:tahun_mulai',
            'tujuan'        => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        MasterTujuan::create($validateData);
        $request->session()->put('status', 'Berhasil menambahkan tujuan Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Tujuan Inspektorat Utama',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterTujuan  $masterTujuan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tujuan = MasterTujuan::where('id_tujuan', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Tujuan',
            'data'      => $tujuan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterTujuan  $masterTujuan
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterTujuan $masterTujuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterTujuan  $masterTujuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'tahun_mulai'   => 'required',
            'tahun_selesai' => 'required|after:tahun_mulai',
            'tujuan'        => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        MasterTujuan::where('id_tujuan', $id)
        ->update([
            'tahun_mulai'   => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'tujuan'        => $request->tujuan,
        ]);

        $request->session()->put('status', 'Berhasil memperbarui Tujuan Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterTujuan  $masterTujuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        MasterTujuan::where('id_tujuan', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus Tujuan Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Tujuan Inspektorat Utama',
        ]);

    }
}
