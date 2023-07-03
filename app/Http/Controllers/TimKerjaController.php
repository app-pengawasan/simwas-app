<?php

namespace App\Http\Controllers;

use App\Models\TimKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimKerjaController extends Controller
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
            'nama'      => 'required',
            'unitkerja' => 'required',
            'iku'       => 'required',
            'ketua'     => 'required',
            'tahun'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        TimKerja::create([
            'nama'  => $validateData['nama'],
            'tahun'  => $validateData['tahun'],
            'unitkerja'  => $validateData['unitkerja'],
            'id_iku'  => $validateData['iku'],
            'id_ketua'  => $validateData['ketua'],
        ]);

        $request->session()->put('status', 'Berhasil menambahkan Tim Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Tim Kerja',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function show(TimKerja $timKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(TimKerja $timKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimKerja $timKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimKerja  $timKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        TimKerja::where('id_timkerja', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus tim kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus tim kerja',
        ]);
    }
}
