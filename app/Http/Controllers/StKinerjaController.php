<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\User;
use App\Http\Requests\StoreStKinerjaRequest;
use App\Http\Requests\UpdateStKinerjaRequest;
use App\Models\MasterPimpinan;
use Illuminate\Support\Facades\Storage;

class StKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulan = StKinerja::latest()->where('user_id', auth()->user()->id)->get();
        return view('pegawai.st-kinerja.index')->with('usulan', $usulan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        return view('pegawai.st-kinerja.create', [
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStKinerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStKinerjaRequest $request)
    {
        $validatedData = $request->validate([
            'is_backdate' => 'required',
            'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
            'unit_kerja' => 'required',
            'tim_kerja' => 'required',
            'tugas' => 'required',
            'melaksanakan' => 'required',
            'objek' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'is_gugus_tugas' => 'required',
            'is_perseorangan' => $request->input('is_gugus_tugas') === '0' ? 'required' : '',
            'dalnis_id' => $request->input('is_gugus_tugas') === '1' ? 'required' : '',
            'ketua_koor_id' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
            'anggota' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
            'penandatangan' => 'required',
            'status' => 'required',
            'is_esign' => 'required',
        ],[
            'after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
            'required' => 'Wajib diisi.'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        if (!($validatedData['is_gugus_tugas'])) {
            if ($validatedData['is_perseorangan'] == '0') {
                $validatedData['anggota'] = implode(', ', $validatedData['anggota']);
            }
        } else {
            $validatedData['anggota'] = implode(', ', $validatedData['anggota']);
        }
        StKinerja::create($validatedData);

        return redirect('/pegawai/st-kinerja')->with('success', 'Pengajuan ST Kinerja berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function show(StKinerja $stKinerja)
    {
        $anggotaArray = explode(', ', $stKinerja->anggota);
        $users = \App\Models\User::whereIn('id', $anggotaArray)->get();
        $nama = $users->pluck('name')->toArray();
        $anggota = implode(', ', $nama);
        return view('pegawai.st-kinerja.show', [
            "title" => "Detail Usulan Surat Tugas Kinerja",
            "usulan" => $stKinerja,
            "anggota" => $anggota
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function edit(StKinerja $st_kinerja)
    {
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        return view('pegawai.st-kinerja.edit', [
            "usulan" => $st_kinerja,
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStKinerjaRequest  $request
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStKinerjaRequest $request, StKinerja $st_kinerja)
    {
        if ($request->input('status') == 0) {
            $validatedData = $request->validate([
                'is_backdate' => 'required',
                'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                'unit_kerja' => 'required',
                'tim_kerja' => 'required',
                'tugas' => 'required',
                'melaksanakan' => 'required',
                'objek' => 'required',
                'mulai' => 'required|date',
                'selesai' => 'required|date|after_or_equal:mulai',
                'is_gugus_tugas' => 'required',
                'is_perseorangan' => $request->input('is_gugus_tugas') === '0' ? 'required' : '',
                'dalnis_id' => $request->input('is_gugus_tugas') === '1' ? 'required' : '',
                'ketua_koor_id' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
                'anggota' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
                'penandatangan' => 'required',
                'status' => 'required',
                'is_esign' => 'required',
            ],[
                'after_or_equal' => 'Waktu selesai harus setelah atau sama dengan waktu mulai.',
                'required' => 'Wajib diisi.'
            ]);
    
            if (!($validatedData['is_gugus_tugas'])) {
                if ($validatedData['is_perseorangan'] == '0') {
                    $validatedData['anggota'] = implode(', ', $validatedData['anggota']);
                }
            } else {
                $validatedData['anggota'] = implode(', ', $validatedData['anggota']);
            }
            StKinerja::where('id', $st_kinerja->id)->update($validatedData);
    
            return redirect('/pegawai/st-kinerja')->with('success', 'Pengajuan kembali usulan ST Kinerja berhasil!');
        } elseif ($request->input('status') == 3) {
            $validatedData = $request->validate([
                'status' => 'required',
                'file' => 'required|mimes:pdf'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => 'File yang diupload harus bertipe .pdf'
            ]);
            $no_surat = $st_kinerja->no_surat;
            $file = $request->input('file');
            if ($file) {
                Storage::delete($file);
            }
            $validatedData['file'] = $request->file('file')->store('st-kinerja');
            StKinerja::where('no_surat', $no_surat)->update($validatedData);
            return redirect('/pegawai/st-kinerja')->with('success', 'Berhasil mengunggah file!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StKinerja  $stKinerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(StKinerja $stKinerja)
    {
        //
    }

    public function form()
    {
        return view('pegawai.st-kinerja.form', [
            "title" => "Ajukan Usulan Surat Tugas Kinerja",
        ]);
    }
}
