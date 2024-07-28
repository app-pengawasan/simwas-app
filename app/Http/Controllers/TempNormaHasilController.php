<?php

namespace App\Http\Controllers;

use App\Models\NormaHasil;
use App\Models\NormaHasilTim;
use App\Models\TempNormaHasil;
use App\Models\NormaHasilAccepted;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTempNormaHasilRequest;
use App\Http\Requests\UpdateTempNormaHasilRequest;
use App\Models\MasterLaporan;

class TempNormaHasilController extends Controller
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
     * @param  \App\Http\Requests\StoreTempNormaHasilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTempNormaHasilRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TempNormaHasil  $tempNormaHasil
     * @return \Illuminate\Http\Response
     */
    public function show(TempNormaHasil $tempNormaHasil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TempNormaHasil  $tempNormaHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(TempNormaHasil $tempNormaHasil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTempNormaHasilRequest  $request
     * @param  \App\Models\TempNormaHasil  $tempNormaHasil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTempNormaHasilRequest $request, TempNormaHasil $tempNormaHasil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TempNormaHasil  $tempNormaHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(TempNormaHasil $tempNormaHasil)
    {
        //
    }

    public function migrateNormaHasil()
    {
        // dd('migrate');
        $tempNormaHasil = TempNormaHasil::get();
        foreach ($tempNormaHasil as $tempNormaHasil) {
            DB::transaction(function () use ($tempNormaHasil) {
                $jenisNormaHasil = MasterLaporan::where('kode', $tempNormaHasil->jenis_norma_hasil)->first();
                if (!$jenisNormaHasil) {
                    return;
                }
                else {
                    $normaHasil = NormaHasil::create([
                        'unit_kerja' => $tempNormaHasil->unit_kerja,
                        'jenis_norma_hasil_id' => $jenisNormaHasil->id,
                        'document_path' => $tempNormaHasil->document_path,
                        'nama_dokumen' => $tempNormaHasil->nama_dokumen,
                        'tanggal' => $tempNormaHasil->tanggal,
                        'status_norma_hasil' => 'disetujui',
                    ]);
                    $lastNormaHasil = $normaHasil->id;
                    $normaHasilAccepted = NormaHasilAccepted::create([
                        'id_norma_hasil' => $lastNormaHasil,
                        'nomor_norma_hasil' => $tempNormaHasil->nomor,
                        'kode_klasifikasi_arsip' => "PW.120",
                        'tanggal_norma_hasil' => $tempNormaHasil->tanggal,
                        'status_verifikasi_arsiparis' => 'disetujui',
                        'unit_kerja' => $tempNormaHasil->unit_kerja,
                        'kode_norma_hasil' => $jenisNormaHasil->id,
                    ]);
                    $lastNormaHasilAccepted = $normaHasilAccepted->id;
                    NormaHasilTim::create([
                        'jenis' => 1,
                        'laporan_id' => $lastNormaHasilAccepted,
                    ]);
                    $tempNormaHasil->delete();
                }
            });
        }
    }



}
