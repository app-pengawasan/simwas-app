<?php

namespace App\Http\Controllers;

use App\Models\TargetIkuUnitKerja;
use App\Http\Requests\StoreTargetIkuUnitKerjaRequest;
use App\Http\Requests\UpdateTargetIkuUnitKerjaRequest;

class TargetIkuUnitKerjaController extends Controller
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
        return view('perencana.target-iku.index', [
            'type_menu' => 'target-iku-unit-kerja'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perencana.target-iku.create', [
            'type_menu' => 'target-iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTargetIkuUnitKerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTargetIkuUnitKerjaRequest $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetIkuUnitKerjaRequest  $request
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetIkuUnitKerjaRequest $request, TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        //
    }
}
