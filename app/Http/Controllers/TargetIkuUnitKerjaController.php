<?php

namespace App\Http\Controllers;

use App\Models\TargetIkuUnitKerja;
use App\Models\RealisasiIkuUnitKerja;
use App\Http\Requests\StoreTargetIkuUnitKerjaRequest;
use App\Http\Requests\UpdateTargetIkuUnitKerjaRequest;
use App\Models\ObjekIkuUnitKerja;

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
        $targetIkuUnitKerja = TargetIkuUnitKerja::all();
        // dd($targetIkuUnitKerja);
        return view('perencana.target-iku.index', [
            'type_menu' => 'iku-unit-kerja',
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
        return view('perencana.target-iku.create', [
            'type_menu' => 'iku-unit-kerja',
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
        // create
        // dd($request->all());
        TargetIkuUnitKerja::create([
            'unit_kerja' => $request->input('unit-kerja'),
            'jumlah_objek' => $request->input('jumlah-objek'),
            'nama_kegiatan' => $request->input('nama-kegiatan'),
            'status' => '1',
            'user_id' => auth()->user()->id,
        ]);
        $jumlahObjek = $request->input('jumlah-objek');
        for ($i = 1; $i <= $jumlahObjek; $i++) {
            $satuan = $request->input('satuan-row' . $i);
            $nilaiY = $request->input('nilai-y-row' . $i);
            $target_triwulan_1 = $request->input('triwulan1-row' . $i);
            $target_triwulan_2 = $request->input('triwulan2-row' . $i);
            $target_triwulan_3 = $request->input('triwulan3-row' . $i);
            $target_triwulan_4 = $request->input('triwulan4-row' . $i);
            $status = '1';
            $user_id = auth()->user()->id;
            $id_target = TargetIkuUnitKerja::latest()->first()->id;
            ObjekIkuUnitKerja::create([
                'id' => (string) \Symfony\Component\Uid\Ulid::generate(),
                'satuan' => $satuan,
                'id_target' => $id_target,
                'nilai_y_target' => $nilaiY ?? 0,
                'target_triwulan_1' => $target_triwulan_1 ?? 0,
                'target_triwulan_2' => $target_triwulan_2 ?? 0,
                'target_triwulan_3' => $target_triwulan_3 ?? 0,
                'target_triwulan_4' => $target_triwulan_4 ?? 0,
                'status' => $status,
                'user_id' => $user_id,
            ]);

        }
        return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Menambahkan UTarget IKU Unit Kerja')
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // dd($targetIkuUnitKerja);
        $objekIkuUnitKerja = objekIkuUnitKerja::where('id_target', $targetIkuUnitKerja->id)->get();
        // dd($objekIkuUnitKerja);
        return view('perencana.target-iku.show', [
            'type_menu' => 'iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // dd($targetIkuUnitKerja);
        $objekIkuUnitKerja = objekIkuUnitKerja::where('id_target', $targetIkuUnitKerja->id)->get();
        // dd($objekIkuUnitKerja);
        return view('perencana.target-iku.edit', [
            'type_menu' => 'iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
        ]);
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
        // dd($request->all());
        TargetIkuUnitKerja::where('id', $targetIkuUnitKerja->id)
            ->update([
                'unit_kerja' => $request->input('unit-kerja'),
                'jumlah_objek' => $request->input('jumlah-objek'),
                'nama_kegiatan' => $request->input('nama-kegiatan'),
                'status' => '1',
                'user_id' => auth()->user()->id,
            ]);
        $jumlahObjek = $request->input('jumlah-objek');
        for ($i = 1; $i <= $jumlahObjek; $i++) {
            $satuan = $request->input('satuan-row' . $i);
            $nilaiY = $request->input('nilai-y-row' . $i);
            $target_triwulan_1 = $request->input('triwulan1-row' . $i);
            $target_triwulan_2 = $request->input('triwulan2-row' . $i);
            $target_triwulan_3 = $request->input('triwulan3-row' . $i);
            $target_triwulan_4 = $request->input('triwulan4-row' . $i);
            $status = '1';
            $user_id = auth()->user()->id;
            $id_target = $targetIkuUnitKerja->id;
            $objekIkuUnitKerja = ObjekIkuUnitKerja::updateOrCreate(
                ['id_target' => $id_target],
                [
                    'satuan' => $satuan,
                    'nilai_y_target' => $nilaiY ?? 0,
                    'target_triwulan_1' => $target_triwulan_1 ?? 0,
                    'target_triwulan_2' => $target_triwulan_2 ?? 0,
                    'target_triwulan_3' => $target_triwulan_3 ?? 0,
                    'target_triwulan_4' => $target_triwulan_4 ?? 0,
                    'status' => $status,
                    'user_id' => $user_id,
                ]
            );

        }
        return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Mengubah Target IKU Unit Kerja')
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // delete
        $targetIkuUnitKerja->delete();
    }

    public function editStatus($id)
    {
        // dd($targetIkuUnitKerja);

        $status = request()->input('status');
        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $id)->first();

        if ($status == 2) {
            TargetIkuUnitKerja::where('id', $targetIkuUnitKerja->id)
        ->update([
            'status' => $status,
        ]);
            return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Mengirim ke Realisasi')
            ->with('alert-type', 'success');
        }
        else if ($status == 3) {
            if($realisasiIkuUnitKerja == null) {
                return redirect()->route('realisasi-iku-unit-kerja.index')->with('status', 'Realisasi IKU Unit Kerja Belum Diisi')
                ->with('alert-type', 'danger');
            } else{
                TargetIkuUnitKerja::where('id', $targetIkuUnitKerja->id)
        ->update([
            'status' => $status,
        ]);
            return redirect()->route('realisasi-iku-unit-kerja.index')->with('status', 'Berhasil Mengirim ke Evaluasi')
            ->with('alert-type', 'success');
            }
        }

    }
}
