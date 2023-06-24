<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnggaranRencanaKerja;
use Illuminate\Support\Facades\Validator;

class AnggaranRencanaKerjaController extends Controller
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
        $pattern = '/[^,\d]/';
        $rules = [
            'id_rencanakerja'   => 'required',
            'uraian'            => 'required',
            'volume'            => 'required',
            'satuan'            => 'required',
            'harga'             => 'required',
            'total'             => 'required',
        ];
        $validateData = $request->validate($rules);

        $validateData["harga"] = preg_replace($pattern, "", $request->harga);
        $validateData["total"] = preg_replace($pattern, "", $request->total);

        AnggaranRencanaKerja::create($validateData);

        return response()->json([
            'success'   => true,
            'message'   => 'Anggaran Berhasil Ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnggaranRencanaKerja  $anggaranRencanaKerja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggaran = AnggaranRencanaKerja::where('id_rkanggaran', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Anggaran Rencana Kerja',
            'data'      => $anggaran[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnggaranRencanaKerja  $anggaranRencanaKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(AnggaranRencanaKerja $anggaranRencanaKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnggaranRencanaKerja  $anggaranRencanaKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pattern = '/[^,\d]/';
        $rules = [
            // 'id_rkanggaran'     => 'required',
            'uraian'            => 'required',
            'volume'            => 'required',
            'satuan'            => 'required',
            'harga'             => 'required',
            'total'             => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        AnggaranRencanaKerja::where('id_rkanggaran', $request->id_rkanggaran)
        ->update([
            'uraian'            => $request->uraian,
            'volume'            => $request->volume,
            'satuan'            => $request->satuan,
            'harga'             => preg_replace($pattern, "", $request->harga),
            'total'             => preg_replace($pattern, "", $request->total),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Anggaran Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnggaranRencanaKerja  $anggaranRencanaKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AnggaranRencanaKerja::where('id_rkanggaran', $id)->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Anggaran Berhasil Dihapus'
        ]);
    }
}
