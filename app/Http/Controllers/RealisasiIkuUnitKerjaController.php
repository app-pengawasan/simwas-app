<?php

namespace App\Http\Controllers;

use App\Models\RealisasiIkuUnitKerja;
use App\Http\Requests\StoreRealisasiIkuUnitKerjaRequest;
use App\Http\Requests\UpdateRealisasiIkuUnitKerjaRequest;

class RealisasiIkuUnitKerjaController extends Controller
{
    protected $kabupaten = [
        'Kabupaten Aceh Barat',
        'Kabupaten Aceh Barat Daya',
        'Kabupaten Aceh Besar',
        'Kabupaten Aceh Jaya',
        'Kabupaten Aceh Selatan',
    ];
    protected $unitKerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];
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
        return view('perencana.realisasi-iku.create', [
            'type_menu' => 'realisasi-iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRealisasiIkuUnitKerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRealisasiIkuUnitKerjaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RealisasiIkuUnitKerja  $realisasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(RealisasiIkuUnitKerja $realisasiIkuUnitKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealisasiIkuUnitKerja  $realisasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(RealisasiIkuUnitKerja $realisasiIkuUnitKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRealisasiIkuUnitKerjaRequest  $request
     * @param  \App\Models\RealisasiIkuUnitKerja  $realisasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRealisasiIkuUnitKerjaRequest $request, RealisasiIkuUnitKerja $realisasiIkuUnitKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RealisasiIkuUnitKerja  $realisasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealisasiIkuUnitKerja $realisasiIkuUnitKerja)
    {
        //
    }
}
