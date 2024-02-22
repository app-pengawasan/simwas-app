<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiIkuUnitKerja;
use App\Models\TargetIkuUnitKerja;
use App\Http\Requests\StoreEvaluasiIkuUnitKerjaRequest;
use App\Http\Requests\UpdateEvaluasiIkuUnitKerjaRequest;

class EvaluasiIkuUnitKerjaController extends Controller
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
        $targetIkuUnitKerja = TargetIkuUnitKerja::whereIn('status', [3])->get();

        return view('perencana.evaluasi-iku.index', [
            'type_menu' => 'iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perencana.evaluasi-iku.create', [
            'type_menu' => 'evaluasi-iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEvaluasiIkuUnitKerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluasiIkuUnitKerjaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvaluasiIkuUnitKerja  $evaluasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(EvaluasiIkuUnitKerja $evaluasiIkuUnitKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvaluasiIkuUnitKerja  $evaluasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        return view('perencana.evaluasi-iku.create', [
            'type_menu' => 'evaluasi-iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEvaluasiIkuUnitKerjaRequest  $request
     * @param  \App\Models\EvaluasiIkuUnitKerja  $evaluasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEvaluasiIkuUnitKerjaRequest $request, EvaluasiIkuUnitKerja $evaluasiIkuUnitKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvaluasiIkuUnitKerja  $evaluasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluasiIkuUnitKerja $evaluasiIkuUnitKerja)
    {
        //
    }
}
