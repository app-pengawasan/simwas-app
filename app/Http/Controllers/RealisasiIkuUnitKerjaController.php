<?php

namespace App\Http\Controllers;

use App\Models\RealisasiIkuUnitKerja;
use App\Http\Requests\StoreRealisasiIkuUnitKerjaRequest;
use App\Http\Requests\UpdateRealisasiIkuUnitKerjaRequest;
use App\Models\TargetIkuUnitKerja;
use App\Models\ObjekIkuUnitKerja;
use Illuminate\Http\Request;

class RealisasiIkuUnitKerjaController extends Controller
{
    protected $unitKerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];
    protected $colorBadge = [
        '1' => 'secondary',
        '2' => 'warning',
        '3' => 'info',
        '4' => 'success',
    ];

    protected $status = [
        '1' => 'Penyusunan Target',
        '2' => 'Penyusunan Realisasi',
        '3' => 'Penyusunan Evaluasi',
        '4' => 'Selesai',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('perencana');
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $targetIkuUnitKerja = TargetIkuUnitKerja::whereIn('status', [2, 3, 4])->whereYear('created_at', $year)->get();

        $year = TargetIkuUnitKerja::selectRaw('YEAR(created_at) year')->whereIn('status', [2, 3, 4])->distinct()->orderBy('year', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');


        return view('perencana.realisasi-iku.index', [
            'type_menu' => 'iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'colorBadge' => $this->colorBadge,
            'status' => $this->status,
            'unit_kerja' => $this->unitKerja,
            'year' => $year,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('perencana');

        return view('perencana.realisasi-iku.create', [
            'type_menu' => 'iku-unit-kerja',
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
        // dd($request->all());
        for ($i = 1; $i <= (int) $request->jumlah_objek; $i++) {
            // update ObjekIkuUnitKerja where id = $request->id_objek.$i
            $objekIkuUnitKerja = ObjekIkuUnitKerja::find($request->input('id_objek' . $i));
            $objekIkuUnitKerja->update([
                'nilai_y_realisasi' => $request->input('nilai-y-row' . $i),
                'realisasi_triwulan_1' => $request->input('triwulan1-row' . $i),
                'realisasi_triwulan_2' => $request->input('triwulan2-row' . $i),
                'realisasi_triwulan_3' => $request->input('triwulan3-row' . $i),
                'realisasi_triwulan_4' => $request->input('triwulan4-row' . $i),
            ]);
        }
        if ($request->file('dokumen_sumber') != null) {
            $dokumenSumberPath = $request->file('dokumen_sumber');
            $dokumenSumberPathName = 'realisasi-iku-unit-kerja-' . time() . '.' . $dokumenSumberPath->getClientOriginalExtension();
            $dokumenSumberPath->move(public_path('storage/realisasi-iku-unit-kerja'), $dokumenSumberPathName);
        }
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $request->input('id'))->first();
        // if realisasi iku unit kerja is exist
        if ($realisasiIkuUnitKerja) {
            // update
            $realisasiIkuUnitKerja->update([
                'catatan' => $request->input('catatan'),
                'dokumen_sumber_path' => $dokumenSumberPathName ?? $realisasiIkuUnitKerja->dokumen_sumber_path,
            ]);
            return redirect()->route('perencana.realisasi-iku-unit-kerja.index')->with('status', 'Berhasil Mengubah Realisasi IKU Unit Kerja');
        }
        else {
            // create
            RealisasiIkuUnitKerja::create([
                'id_target_iku_unit_kerja' => $request->input('id'),
                'catatan' => $request->input('catatan'),
                'dokumen_sumber_path' => $dokumenSumberPathName,
            ]);
        }
        // update status target iku unit kerja where id = $request->input('id')
        $targetIkuUnitKerja = TargetIkuUnitKerja::find($request->input('id'));

        return redirect()->route('perencana.realisasi-iku-unit-kerja.index')->with('status', 'Berhasil Menambahkan Realisasi IKU Unit Kerja');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RealisasiIkuUnitKerja  $realisasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('perencana');

        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        $objekIkuUnitKerja = objekIkuUnitKerja::with('master_objeks')->where('id_target', $targetIkuUnitKerja->id)->get();
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $id)->first();
        if (!$realisasiIkuUnitKerja) {
            return redirect()->route('perencana.realisasi-iku-unit-kerja.edit', $id)->with('status', 'Anda Belum Mengisi Realisasi IKU Unit Kerja, Silakan Mengisi Realisasi IKU Unit Kerja')
            ->with('alert-type', 'warning');
        }
        // dd($objekIkuUnitKerja);
        return view('perencana.realisasi-iku.show', [
            'type_menu' => 'iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
            'realisasiIkuUnitKerja' => $realisasiIkuUnitKerja,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealisasiIkuUnitKerja  $realisasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        $objekIkuUnitKerja = objekIkuUnitKerja::with('master_objeks')->where('id_target', $targetIkuUnitKerja->id)->get();
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $id)->first();


        return view('perencana.realisasi-iku.edit', [
            'type_menu' => 'iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
            'realisasiIkuUnitKerja' => $realisasiIkuUnitKerja,
        ]);
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
