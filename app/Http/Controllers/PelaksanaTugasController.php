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
            'pelaksana'        => 'required',
            'pt_jabatan'        => 'required',
            'jan'               => 'required',
            'feb'               => 'required',
            'mar'               => 'required',
            'apr'               => 'required',
            'mei'               => 'required',
            'jun'               => 'required',
            'jul'               => 'required',
            'agu'               => 'required',
            'sep'               => 'required',
            'okt'               => 'required',
            'nov'               => 'required',
            'des'               => 'required',
        ];
        $validateData = $request->validate($rules);

        PelaksanaTugas::create([
            'id_rencanakerja'   => $validateData['id_rencanakerja'],
            'id_pegawai'        => $validateData['pelaksana'],
            'pt_jabatan'        => $validateData['pt_jabatan'],
            'jan'            => $validateData['jan'],
            'feb'            => $validateData['feb'],
            'mar'            => $validateData['mar'],
            'apr'            => $validateData['apr'],
            'mei'            => $validateData['mei'],
            'jun'            => $validateData['jun'],
            'jul'            => $validateData['jul'],
            'agu'            => $validateData['agu'],
            'sep'            => $validateData['sep'],
            'okt'            => $validateData['okt'],
            'nov'            => $validateData['nov'],
            'des'            => $validateData['des'],

        ]);

        $request->session()->put('status', 'Berhasil menambahkan Pelaksana Tugas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan Pelaksana Tugas',
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
            'pelaksana'        => 'required',
            'pt_jabatan'        => 'required',
            'jan'               => 'required',
            'feb'               => 'required',
            'mar'               => 'required',
            'apr'               => 'required',
            'mei'               => 'required',
            'jun'               => 'required',
            'jul'               => 'required',
            'agu'               => 'required',
            'sep'               => 'required',
            'okt'               => 'required',
            'nov'               => 'required',
            'des'               => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        PelaksanaTugas::where('id_pelaksana', $request->id_pelaksana)
        ->update([
            'id_pegawai'    => $request->pelaksana,
            'pt_jabatan'    => $request->pt_jabatan,
            'jan'           => $request->jan,
            'feb'           => $request->feb,
            'mar'           => $request->mar,
            'apr'           => $request->apr,
            'mei'           => $request->mei,
            'jun'           => $request->jun,
            'jul'           => $request->jul,
            'agu'           => $request->agu,
            'sep'           => $request->sep,
            'okt'           => $request->okt,
            'nov'           => $request->nov,
            'des'           => $request->des,
        ]);

        $request->session()->put('status', 'Berhasil memperbarui Pelaksana Tugas.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui Pelaksana Tugas',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelaksanaTugas  $pelaksanaTugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        PelaksanaTugas::where('id_pelaksana', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus Pelaksana.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Pelaksana',
        ]);
    }
}
