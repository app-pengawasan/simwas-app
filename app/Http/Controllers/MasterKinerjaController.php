<?php

namespace App\Http\Controllers;

use App\Models\MasterKinerja;
use App\Http\Requests\StoreMasterKinerjaRequest;
use App\Http\Requests\UpdateMasterKinerjaRequest;
use App\Models\MasterHasilKerja;
use App\Models\MasterKinerjaPegawai;

class MasterKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
        $hasilKerja = MasterHasilKerja::all();
        $hasilKinerja = MasterKinerja::with('masterHasilKerja', 'masterKinerjaPegawai')->latest()->get();

        return view('admin.master-kinerja.index', [
            'type_menu' => 'rencana-kinerja',
            'hasilKerja' => $hasilKerja,
            'hasilKinerja' => $hasilKinerja,
        ]);
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
     * @param  \App\Http\Requests\StoreMasterKinerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterKinerjaRequest $request)
    {
        // dd($request->all());
       $roles = [
            1 =>  'pengendaliTeknis',
            2 =>  'ketuaTim',
            3 =>  'PIC',
            4 =>  'anggotaTim',
            5 =>  'penanggungJawabKegiatan',
        ];

        $data = $request->all();

        try {
            MasterKinerja::create([
                'hasil_kerja_id' => $data['hasilKerjaID'],
            ]);
            // get the last inserted id
            $lastInsertedID = MasterKinerja::latest()->first()->id;
            foreach ($roles as $key => $value) {
                if(request()->has('iki_'.$value) == false){
                    continue;
                }
                MasterKinerjaPegawai::create([
                    'kinerja_id' => $lastInsertedID,
                    'pt_jabatan' => $key,
                    'hasil_kerja' => $data['hasilKerja_'.$value],
                    'rencana_kinerja' => $data['rencanaKinerja_'.$value],
                    'iki' => $data['iki_'.$value],
                    'kegiatan' => $data['kegiatan_'.$value],
                    'capaian' => $data['capaian_'.$value],
                ]);
            }
            return redirect()->route('admin.master-kinerja.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('admin.master-kinerja.index')->with('status', 'Data gagal ditambahkan, data sudah ada')->with('alert-type', 'danger');
            } else {
                return redirect()->route('admin.master-kinerja.index')->with('status', 'Data gagal ditambahkan, Periksa lagi data anda')->with('alert-type', 'danger');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterKinerja  $masterKinerja
     * @return \Illuminate\Http\Response
     */
    public function show(MasterKinerja $masterKinerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterKinerja  $masterKinerja
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterKinerja $masterKinerja)
    {
        dd($masterKinerja->masterKinerjaPegawai);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterKinerjaRequest  $request
     * @param  \App\Models\MasterKinerja  $masterKinerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterKinerjaRequest $request, $id)
    {
        $roles = [
            1 =>  'pengendaliTeknis',
            2 =>  'ketuaTim',
            3 =>  'PIC',
            4 =>  'anggotaTim',
            5 =>  'penanggungJawabKegiatan',
        ];

        $data = $request->all();

        try {
            MasterKinerja::where('id', $id)->update([
                'hasil_kerja_id' => $data['editHasilKerjaID'],
            ]);
            // delete all data in master_kinerja_pegawai
            MasterKinerjaPegawai::where('kinerja_id', $id)->delete();

            foreach ($roles as $key => $value) {
                if(request()->has('editIki_'.$value) == false){
                    continue;
                }
                MasterKinerjaPegawai::create([
                    'kinerja_id' => $id,
                    'pt_jabatan' => $key,
                    'hasil_kerja' => $data['editHasilKerja_'.$value],
                    'rencana_kinerja' => $data['editRencanaKinerja_'.$value],
                    'iki' => $data['editIki_'.$value],
                    'kegiatan' => $data['editKegiatan_'.$value],
                    'capaian' => $data['editCapaian_'.$value],
                ]);
            }

            return redirect()->route('admin.master-kinerja.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success');

        } catch (\Throwable $th) {
            return redirect()->route('admin.master-kinerja.index')->with('status', 'Data gagal diubah')->with('alert-type', 'danger');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterKinerja  $masterKinerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterKinerja $masterKinerja)
    {
        try {
            $masterKinerja->masterKinerjaPegawai()->delete();
            $masterKinerja->delete();
            return redirect()->route('admin.master-kinerja.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('admin.master-kinerja.index')->with('status', 'Data gagal dihapus')->with('alert-type', 'danger');
        }
    }

    public function showMasterKinerja($id)
    {
        $masterKinerja = MasterKinerja::with('masterKinerjaPegawai', 'masterHasilKerja')->find($id);
        return response()->json($masterKinerja);
    }
}
