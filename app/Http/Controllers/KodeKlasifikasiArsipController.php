<?php

namespace App\Http\Controllers;

use App\Models\KodeKlasifikasiArsip;
use App\Http\Requests\StoreKodeKlasifikasiArsipRequest;
use App\Http\Requests\UpdateKodeKlasifikasiArsipRequest;

class KodeKlasifikasiArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');

        $kodeKlasifikasiArsips = KodeKlasifikasiArsip::all();
        return view('admin.master-kka.index', [
            'type_menu' => 'master-arsip',
            'kodeKlasifikasiArsips' => $kodeKlasifikasiArsips,
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
     * @param  \App\Http\Requests\StoreKodeKlasifikasiArsipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKodeKlasifikasiArsipRequest $request)
    {
        try {
            $data = $request->validated();
            KodeKlasifikasiArsip::create([
                'kode' => $data['kode-kka'],
                'uraian' => $data['uraian-kka'],
                'is_aktif' => '1',
            ]);
            return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data berhasil ditambahkan')->with('alert-type', 'success');


        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal ditambahkan, data sudah ada')->with('alert-type', 'danger');
            }
            return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal ditambahkan, silakan periksa data lagi')->with('alert-type', 'danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KodeKlasifikasiArsip  $kodeKlasifikasiArsip
     * @return \Illuminate\Http\Response
     */
    public function show(KodeKlasifikasiArsip $kodeKlasifikasiArsip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KodeKlasifikasiArsip  $kodeKlasifikasiArsip
     * @return \Illuminate\Http\Response
     */
    public function edit(KodeKlasifikasiArsip $kodeKlasifikasiArsip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKodeKlasifikasiArsipRequest  $request
     * @param  \App\Models\KodeKlasifikasiArsip  $kodeKlasifikasiArsip
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKodeKlasifikasiArsipRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $kodeKlasifikasiArsip = KodeKlasifikasiArsip::findOrFail($id);
            $kodeKlasifikasiArsip->update([
                'kode' => $data['kode-kka'],
                'uraian' => $data['uraian-kka'],
            ]);
            return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data berhasil diubah')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1062) {
                return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal diubah, data sudah ada')->with('alert-type', 'danger');
            }
            return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal diubah, silakan periksa data lagi')->with('alert-type', 'danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KodeKlasifikasiArsip  $kodeKlasifikasiArsip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $kodeKlasifikasiArsip = KodeKlasifikasiArsip::findOrFail($id);
            // if it used by another table, it will throw an error
            if ($kodeKlasifikasiArsip->usulanSuratSrikandi()->count() > 0) {
                return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal dihapus, data masih digunakan')->with('alert-type', 'danger');
            }
            if ($kodeKlasifikasiArsip->suratSrikandi()->count() > 0) {
                return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal dihapus, data masih digunakan')->with('alert-type', 'danger');
            }
            $kodeKlasifikasiArsip->delete();
            return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data berhasil dihapus')->with('alert-type', 'success');
        } catch (\Throwable $th) {
            if ($th->errorInfo[1] == 1451) {
                return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal dihapus, data masih digunakan')->with('alert-type', 'danger');
            }
            return redirect()->route('admin.master-kode-klasifikasi-arsip.index')->with('status', 'Data gagal dihapus, silakan periksa data lagi')->with('alert-type', 'danger');
        }
    }

    public function editStatus($id)
    {
        try {
            $kodeKlasifikasiArsip = KodeKlasifikasiArsip::findOrFail($id);
            $kodeKlasifikasiArsip->update([
                'is_aktif' => !$kodeKlasifikasiArsip->is_aktif,
            ]);
            // return json message
            return response()->json([
                'status' => 'success',
                'message' => 'Status berhasil diubah',
            ]);
        } catch (\Throwable $th) {
            // return json message
            return response()->json([
                'status' => 'error',
                'message' => 'Status gagal diubah',
            ], 500);
        }
    }
}
