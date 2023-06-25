<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use Illuminate\Support\Facades\Validator;

class PelaksanaTugasController extends Controller
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
            'id_pegawai'        => 'required',
            'pt_jabatan'        => 'required',
            'pt_hasil'          => 'required',
        ];
        $validateData = $request->validate($rules);

        PelaksanaTugas::create($validateData);

        return response()->json([
            'success'   => true,
            'message'   => 'Pelaksana Tugas Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PelaksanaTugas  $pelaksanaTugas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelaksanaRK = PelaksanaTugas::where('id_pelaksana',$id)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Anggaran Rencana Kerja',
            'data'      => $pelaksanaRK[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelaksanaTugas  $pelaksanaTugas
     * @return \Illuminate\Http\Response
     */
    public function edit(PelaksanaTugas $pelaksanaTugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelaksanaTugas  $pelaksanaTugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'id_pelaksana'      => 'required',
            'id_pegawai'        => 'required',
            'pt_jabatan'        => 'required',
            'pt_hasil'          => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        PelaksanaTugas::where('id_pelaksana', $request->id_pelaksana)
        ->update([
            'id_pegawai'    => $request->id_pegawai,
            'pt_jabatan'    => $request->pt_jabatan,
            'pt_hasil'      => $request->pt_hasil,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Pelaksana Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelaksanaTugas  $pelaksanaTugas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PelaksanaTugas::where('id_pelaksana', $id)->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Pelaksana Berhasil Dihapus'
        ]);
    }
}
