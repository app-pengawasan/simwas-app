<?php

namespace App\Http\Controllers;

use App\Models\LaporanObjekPengawasan;
use App\Http\Requests\StoreLaporanObjekPengawasanRequest;
use App\Http\Requests\UpdateLaporanObjekPengawasanRequest;

class LaporanObjekPengawasanController extends Controller
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
     * @param  \App\Http\Requests\StoreLaporanObjekPengawasanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLaporanObjekPengawasanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LaporanObjekPengawasan  $laporanObjekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function show(LaporanObjekPengawasan $laporanObjekPengawasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LaporanObjekPengawasan  $laporanObjekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function edit(LaporanObjekPengawasan $laporanObjekPengawasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLaporanObjekPengawasanRequest  $request
     * @param  \App\Models\LaporanObjekPengawasan  $laporanObjekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaporanObjekPengawasanRequest $request, LaporanObjekPengawasan $laporanObjekPengawasan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LaporanObjekPengawasan  $laporanObjekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(LaporanObjekPengawasan $laporanObjekPengawasan)
    {
        //
    }

    public function getLaporanObjekPengawasan($id)
    {
        try {
            $laporanObjekPengawasan = LaporanObjekPengawasan::where('id_objek_pengawasan', $id)->doesntHave('normaHasil')->get();
            $laporanObjekPengawasan->load('objekPengawasan');
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $laporanObjekPengawasan
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage()
                ],
                500
            );
        }
    }
}
