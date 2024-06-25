<?php

namespace App\Http\Controllers;

use App\Models\LaporanObjekPengawasan;
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
        // dd($request->all());
        $rules = [
            'id_rencanakerja'   => 'required',
            'objek'          => 'required',
            'kategori_objek'    => 'required',
            'nama'              => 'required',
            'namaLaporan'       => 'required',
            'januari'           => 'required',
            'februari'          => 'required',
            'maret'             => 'required',
            'april'             => 'required',
            'mei'               => 'required',
            'juni'              => 'required',
            'juli'              => 'required',
            'agustus'           => 'required',
            'september'         => 'required',
            'oktober'           => 'required',
            'november'          => 'required',
            'desember'          => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        ObjekPengawasan::create([
            'id_rencanakerja'   => $validateData['id_rencanakerja'],
            'id_objek'          => $validateData['objek'],
            'kategori_objek'    => $validateData['kategori_objek'],
            'nama'              => $validateData['nama'],
            'nama_laporan'      => $validateData['namaLaporan']
        ]);
        // get last id
        // get last id_opengawasan
        $lastId = ObjekPengawasan::latest()->first()->id_opengawasan;

        $month = [
            1 => 'januari',
            2 => 'februari',
            3 => 'maret',
            4 => 'april',
            5 => 'mei',
            6 => 'juni',
            7 => 'juli',
            8 => 'agustus',
            9 => 'september',
            10 => 'oktober',
            11 => 'november',
            12 => 'desember'
        ];

        foreach ($month as $key => $value) {
            LaporanObjekPengawasan::create([
                'id_objek_pengawasan' => $lastId,
                'month' => $key,
                'status' => $validateData[$value]
            ]);
        }

        $request->session()->put('status', 'Berhasil menambahkan Objek Pengawasan.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan Objek Pengawasan',
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
            'objek'          => 'required',
            'kategori_objek' => 'required',
            'nama'           => 'required',
            'namaLaporan'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            ObjekPengawasan::where('id_opengawasan', $request->id_opengawasan)
            ->update([
                'id_objek'          => $request->objek,
                'kategori_objek'    => $request->kategori_objek,
                'nama'              => $request->nama,
                'nama_laporan'      => $request->namaLaporan
            ]);
            // delete laporan objek pengawasan
            LaporanObjekPengawasan::where('id_objek_pengawasan', $request->id_opengawasan)->delete();
            // create laporan objek pengawasan
            $month = [
                1 => 'januari',
                2 => 'februari',
                3 => 'maret',
                4 => 'april',
                5 => 'mei',
                6 => 'juni',
                7 => 'juli',
                8 => 'agustus',
                9 => 'september',
                10 => 'oktober',
                11 => 'november',
                12 => 'desember'
            ];
            foreach ($month as $key => $value) {
                LaporanObjekPengawasan::create([
                    'id_objek_pengawasan' => $request->id_opengawasan,
                    'month' => $key,
                    'status' => $request->$value
                ]);
            }

            $request->session()->put('status', 'Berhasil memperbarui Objek Pengawasan.');
            $request->session()->put('alert-type', 'success');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui Objek Pengawasan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui Objek Pengawasan',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        ObjekPengawasan::where('id_opengawasan', $id)->delete()   ;

        $request->session()->put('status', 'Berhasil menghapus Objek Pengawasan.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Objek Pengawasan',
        ]);
    }

    public function getObjekPengawasan()

    {
        $rencana_id = request()->rencana_id;
        $objek_pengawasan = ObjekPengawasan::with('laporanObjekPengawasan')->where('id_rencanakerja', $rencana_id)->get();
        return response()->json([
            'success' => true,
            'data' => $objek_pengawasan
        ]);
    }

    public function detailObjekPengawasan($id)
    {
        $objek_pengawasan = ObjekPengawasan::with('laporanObjekPengawasan', 'masterObjek')->where('id_opengawasan', $id)->first();
        return response()->json([
            'success' => true,
            'data' => $objek_pengawasan
        ]);
    }

}
