<?php

namespace App\Http\Controllers;

use App\Models\NormaHasil;
use App\Models\MasterLaporan;
use App\Http\Requests\StoreMasterLaporanRequest;
use App\Http\Requests\UpdateMasterLaporanRequest;

class MasterLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');

        $masterLaporans = MasterLaporan::all();
        return view('admin.master-laporan.index', [
            'type_menu' => 'master-arsip',
            'masterLaporans' => $masterLaporans,
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
     * @param  \App\Http\Requests\StoreMasterLaporanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterLaporanRequest $request)
    {
        try {
            $data = $request->validated();
            MasterLaporan::create([
                'kode' => $data['kode-laporan'],
                'nama' => $data['nama-laporan'],
                'is_aktif' => '1',
            ]);
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('admin.master-laporan.index')->with('status', 'Data gagal ditambahkan, data sudah ada')->with('alert-type', 'danger');
            }
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data gagal ditambahkan, silakan periksa data lagi')->with('alert-type', 'danger');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterLaporan  $masterLaporan
     * @return \Illuminate\Http\Response
     */
    public function show(MasterLaporan $masterLaporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterLaporan  $masterLaporan
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterLaporan $masterLaporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterLaporanRequest  $request
     * @param  \App\Models\MasterLaporan  $masterLaporan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterLaporanRequest $request, $id)
    {
        try {
            $data = $request->validated();
            MasterLaporan::where('id', $id)->update([
                'kode' => $data['kode-laporan'],
                'nama' => $data['nama-laporan'],
            ]);
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data gagal diubah, silakan periksa data lagi')->with('alert-type', 'danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterLaporan  $masterLaporan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find normaHasil by jenis_norma_hasil == $id, if exist, return error
        // find normaHasil by jenis_norma_hasil == $id, if exist, return error
        $normaHasil = NormaHasil::where('jenis_norma_hasil_id', $id)->first();
        if ($normaHasil) {
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data gagal dihapus, data masih digunakan')->with('alert-type', 'danger');
        }
        try {
            MasterLaporan::destroy($id);
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            return redirect()->route('admin.master-laporan.index')->with('status', 'Data gagal dihapus, silakan periksa data lagi')->with('alert-type', 'danger');
        }

    }

    public function editStatus($id)
    {
        try {
            $masterLaporan = MasterLaporan::find($id);
            $masterLaporan->is_aktif = !$masterLaporan->is_aktif;
            $masterLaporan->save();
            return response()->json(['status' => 'success', 'message' => 'Status berhasil diubah']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Status gagal diubah'], 500);
        }
    }


}
