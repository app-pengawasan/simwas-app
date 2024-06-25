<?php

namespace App\Http\Controllers;

use App\Models\TimKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OperatorRencanaKinerja;

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
        try{

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
        // get last id after insert
        $timKerja = TimKerja::orderBy('id_timkerja', 'desc')->first();

        // create loop for operator
        if($request->operator != null){
        foreach ($request->operator as $key => $value) {
            OperatorRencanaKinerja::create([
                'tim_kerja_id' => $timKerja->id_timkerja,
                'operator_id' => $value,
            ]);
        }
        }

        $request->session()->put('status', 'Berhasil menambahkan Tim Kerja.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Tim Kerja',
        ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
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
            $rules = [
                'uraian_tugas'  => 'required',
                'rk_ketua'      => 'required',
                'iki_ketua'     => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            $timKerja->update([
                'uraian_tugas'  => $request->uraian_tugas,
                'renca_kerja_ketua' => $request->rk_ketua,
                'iki_ketua'     => $request->iki_ketua,
            ]);
            $request->session()->put('status', 'Berhasil mengubah Tim Kerja');
            $request->session()->put('alert-type', 'success');
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah Tim Kerja',
            ]);
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

    public function detail($id){
        $timKerja = TimKerja::where('id_timkerja', $id)->first();
        // add operator id to array operator
        $operator = OperatorRencanaKinerja::where('tim_kerja_id', $id)->get();
        $operatorId = [];
        foreach ($operator as $key => $value) {
            $operatorId[] = $value->operator_id;
        }
        $timKerja['operator'] = $operatorId;


        return response()->json([
            'success' => true,
            'message' => 'Detail Data Rencana Kerja',
            'data'    => $timKerja,
        ]);
    }

    public function updateTimKerja(Request $request, $id){
        $rules = [
            'id_timkerja' => 'required',
            'tahun' => 'required',
            'unitkerja' => 'required',
            'nama' => 'required',
            'ketua' => 'required',
            'iku' => 'required',
        ];
        $idTimkerja = $request->input('edit-id-timkerja');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $timKerja = TimKerja::where('id_timkerja', $id)->first();
            $timKerja->update([
                'nama' => $request->input('nama'),
                'tahun' => $request->input('tahun'),
                'unitkerja' => $request->input('unitkerja'),
                'id_ketua' => $request->input('ketua'),
                'id_iku' => $request->input('iku'),
            ]);
            $request->session()->put('status', 'Berhasil mengubah tim kerja.');
            $request->session()->put('alert-type', 'success');

            // delete all operator by tim kerja id
            OperatorRencanaKinerja::where('tim_kerja_id', $id)->delete();
            // create loop for operator
            if($request->operator != null){
                foreach ($request->operator as $key => $value) {
                    OperatorRencanaKinerja::create([
                        'tim_kerja_id' => $id,
                        'operator_id' => $value,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah tim kerja',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function lockTimKerja(Request $request, $id){
        try {
            $timKerja = TimKerja::where('id_timkerja', $id)->first();
            $timKerja->update([
                'status' => 2,
            ]);
            return back()->with('status', 'Berhasil mengunci tim kerja.');
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }
    public function unlockTimKerja(Request $request, $id){
        try {
            $timKerja = TimKerja::where('id_timkerja', $id)->first();
            $timKerja->update([
                'status' => 1,
            ]);
            return back()->with('status', 'Berhasil membuka kunci tim kerja.');
        } catch (\Throwable $th) {
            return back()->with('status', $th->getMessage());
        }
    }
}
