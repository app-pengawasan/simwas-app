<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiIkuUnitKerja;
use App\Models\TargetIkuUnitKerja;
use App\Http\Requests\StoreEvaluasiIkuUnitKerjaRequest;
use App\Http\Requests\UpdateEvaluasiIkuUnitKerjaRequest;
use App\Models\ObjekIkuUnitKerja;
use App\Models\RealisasiIkuUnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class EvaluasiIkuUnitKerjaController extends Controller
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

        $this->authorize('perencana');
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }

        $targetIkuUnitKerja = TargetIkuUnitKerja::whereIn('status', [3,4])->whereYear('created_at', $year)->get();
        $year = TargetIkuUnitKerja::selectRaw('YEAR(created_at) year')->whereIn('status', [3, 4])->distinct()->orderBy('year', 'desc')->get();
        $currentYear = date('Y');

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');

        return view('perencana.evaluasi-iku.index', [
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

        return view('perencana.evaluasi-iku.create', [
            'type_menu' => 'iku-unit-kerja',
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
        // dd($request->all());
        $undanganDoc = $request->file('undangan');
        $notulenDoc = $request->file('notulen');
        $laporanDoc = $request->file('laporan_kinerja');
        $daftarHadirDoc = $request->file('daftar_hadir');

        // change file name to be unique
        $undanganDocName = time() . '_' . $request->id . '_undangan' . '.' . $undanganDoc->getClientOriginalExtension();
        $notulenDocName = time() . '_' . $request->id . '_notulen' . '.' . $notulenDoc->getClientOriginalExtension();
        $laporanDocName = time() . '_' . $request->id . '_laporan' . '.' . $laporanDoc->getClientOriginalExtension();
        $daftarHadirDocName = time() . '_' . $request->id . '_daftar_hadir' . '.' . $daftarHadirDoc->getClientOriginalExtension();

        // move file to storage

        EvaluasiIkuUnitKerja::create([
            'id_target_iku_unit_kerja' => $request->id,
            'kendala' => $request->kendala,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'id_pic' => $request->pic_tindak_lanjut,
            'uraian_tindak_lanjut' => $request->bukti_tindak_lanjut,
            'link_tindak_lanjut' => $request->link_bukti_tindak_lanjut,
            'batas_waktu_tindak_lanjut' => $request->batas_waktu,
            'dokumen_undangan_path' => 'storage/evaluasi-iku/undangan/' . $undanganDocName,
            'dokumen_notulen_path' => 'storage/evaluasi-iku/notulen/' . $notulenDocName,
            'dokumen_laporan_path' => 'storage/evaluasi-iku/laporan/' . $laporanDocName,
            'dokumen_daftar_hadir_path' => 'storage/evaluasi-iku/daftar-hadir/' . $daftarHadirDocName,
        ]);
        // update status target iku unit kerja to 4
        $targetIkuUnitKerja = TargetIkuUnitKerja::find($request->id);
        $targetIkuUnitKerja->status = 4;
        $targetIkuUnitKerja->save();


        $undanganDoc->move(public_path('storage/evaluasi-iku/undangan'), $undanganDocName);
        $notulenDoc->move(public_path('storage/evaluasi-iku/notulen'), $notulenDocName);
        $laporanDoc->move(public_path('storage/evaluasi-iku/laporan'), $laporanDocName);
        $daftarHadirDoc->move(public_path('storage/evaluasi-iku/daftar-hadir'), $daftarHadirDocName);

        return redirect()->route('perencana.evaluasi-iku-unit-kerja.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvaluasiIkuUnitKerja  $evaluasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('perencana');

        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        $objekIkuUnitKerja = objekIkuUnitKerja::with('master_objeks')->where('id_target', $targetIkuUnitKerja->id)->get();
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $targetIkuUnitKerja->id)->get();
        $evaluasiIkuUnitKerja = EvaluasiIkuUnitKerja::where('id_target_iku_unit_kerja', $targetIkuUnitKerja->id)->first();


        return view('perencana.evaluasi-iku.show', [
            'type_menu' => 'iku-unit-kerja',
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
            'realisasiIkuUnitKerja' => $realisasiIkuUnitKerja,
            'evaluasiIkuUnitKerja' => $evaluasiIkuUnitKerja,
            'unitKerja' => $this->unitKerja,
            'status' => $this->status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvaluasiIkuUnitKerja  $evaluasiIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('perencana');

        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        $objekIkuUnitKerja = objekIkuUnitKerja::with('master_objeks')->where('id_target', $targetIkuUnitKerja->id)->get();
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $targetIkuUnitKerja->id)->get();
        $users = User::all();
        // dd($users);

        return view('perencana.evaluasi-iku.edit', [
            'type_menu' => 'iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
            'realisasiIkuUnitKerja' => $realisasiIkuUnitKerja,
            'users' => $users,
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
