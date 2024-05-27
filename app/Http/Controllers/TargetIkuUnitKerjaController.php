<?php

namespace App\Http\Controllers;

use App\Models\TargetIkuUnitKerja;
use App\Http\Requests\StoreTargetIkuUnitKerjaRequest;
use App\Http\Requests\UpdateTargetIkuUnitKerjaRequest;
use App\Models\MasterHasil;
use App\Models\ObjekIkuUnitKerja;
use App\Models\MasterUnitKerja;
use Illuminate\Http\Request;
use App\Models\RealisasiIkuUnitKerja;
use App\Models\EvaluasiIkuUnitKerja;

class TargetIkuUnitKerjaController extends Controller
{
    protected $colorBadge = [
        '1' => 'light',
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
    public function index(Request $request)
    {
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        $this->authorize('perencana');
        $targetIkuUnitKerja = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->get();
        // dd($targetIkuUnitKerja);
        $year = TargetIkuUnitKerja::selectRaw('YEAR(created_at) year')->distinct()->orderBy('year', 'desc')->get();

        $currentYear = date('Y');

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');

        return view('perencana.target-iku.index', [
            'type_menu' => 'iku-unit-kerja',
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'status' => $this->status,
            'colorBadge' => $this->colorBadge,
            'unitKerja' => $this->unitKerja,
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
        $masterUnitKerja = MasterUnitKerja::where('kategori', 1)->get();
        // dd($masterUnitKerja);


        return view('perencana.target-iku.create', [
            'type_menu' => 'iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'masterUnitKerja' => $masterUnitKerja,
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
                // 'satuan' => $satuan,
                'id_objek' => $satuan,
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
        $this->authorize('perencana');

        $objekIkuUnitKerja = objekIkuUnitKerja::with('master_objeks')->where('id_target', $targetIkuUnitKerja->id)->get();
        // dd($objekIkuUnitKerja);
        return view('perencana.target-iku.show', [
            'type_menu' => 'iku-unit-kerja',
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
        $this->authorize('perencana');
        $masterUnitKerja = MasterUnitKerja::where('kategori', 1)->get();


        $objekIkuUnitKerja = objekIkuUnitKerja::with('master_objeks')->where('id_target', $targetIkuUnitKerja->id)->get();
        // dd($objekIkuUnitKerja);
        return view('perencana.target-iku.edit', [
            'type_menu' => 'iku-unit-kerja',
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
            'masterUnitKerja' => $masterUnitKerja,
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
            ObjekIkuUnitKerja::where('id_target', $targetIkuUnitKerja->id)->delete();
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
            // delete old objek
            ObjekIkuUnitKerja::create([
                'id' => (string) \Symfony\Component\Uid\Ulid::generate(),
                // 'satuan' => $satuan,
                'id_objek' => $satuan,
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

        EvaluasiIkuUnitKerja::where('id_target_iku_unit_kerja', $targetIkuUnitKerja->id)->delete();
        RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $targetIkuUnitKerja->id)->delete();

        $targetIkuUnitKerja->delete();

        return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Menghapus Target IKU Unit Kerja')
            ->with('alert-type', 'success');
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
