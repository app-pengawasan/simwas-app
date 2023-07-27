<?php

namespace App\Http\Controllers;

use App\Models\Stpd;
use App\Models\StKinerja;
use App\Models\User;
use App\Models\MasterPimpinan;
use App\Http\Requests\StoreStpdRequest;
use App\Http\Requests\UpdateStpdRequest;
use App\Models\Pembebanan;

class StpdController extends Controller
{
    protected $jabatan_pimpinan = [
        'jpm000'      => 'Inspektur Utama',
        'jpm001'      => 'Inspektur Wilayah I',
        'jpm002'      => 'Inspektur Wilayah II',
        'jpm003'      => 'Inspektur Wilayah III',
        'jpm004'      => 'Kepala Bagian Umum'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulan = Stpd::latest()->where('user_id', auth()->user()->id)->get();
        return view('pegawai.st-pd.index')->with('usulan', $usulan);
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
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        $pembebanans = Pembebanan::all();
        return view('pegawai.st-pd.create', [
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "stks" => $stks,
            "pembebanans" => $pembebanans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStpdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStpdRequest $request)
    {
        $validatedData = $request->validate([
            'is_backdate' => 'required',
            'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
            'unit_kerja' => 'required',
            'is_st_kinerja' => 'required',
            'st_kinerja_id' => $request->input('is_st_kinerja') === '1' ? 'required' : '',
            'melaksanakan' => 'required',
            'kota' => 'required',
            'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today',
            'selesai' => 'required|date|after_or_equal:mulai',
            'pelaksana' => 'required',
            'pembebanan_id' => 'required',
            'status' => 'required',
            'penandatangan' => 'required',
            'is_esign' => 'required'
        ],[
            'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
            'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
            'required' => 'Wajib diisi'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['pelaksana'] = implode(', ', $validatedData['pelaksana']);
        
        Stpd::create($validatedData);

        return redirect('/pegawai/st-pd')->with('success', 'Pengajuan ST Perjalanan Dinas berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function show(Stpd $st_pd)
    {
        $pelaksanaArray = explode(', ', $st_pd->pelaksana);
        $users = \App\Models\User::whereIn('id', $pelaksanaArray)->get();
        $nama = $users->pluck('name')->toArray();
        $pelaksana = implode(', ', $nama);
        return view('pegawai.st-pd.show', [
            "usulan" => $st_pd,
            "pelaksana" => $pelaksana,
            "jabatan_pimpinan" =>$this->jabatan_pimpinan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function edit(Stpd $st_pd)
    {
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        $pembebanans = Pembebanan::all()->where('is_aktif', true);
        return view('pegawai.st-pd.edit', [
            "usulan" => $st_pd,
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "jabatan_pimpinan" => $this->jabatan_pimpinan,
            "stks" => $stks,
            "pembebanans" => $pembebanans
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStpdRequest  $request
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStpdRequest $request, Stpd $st_pd)
    {
        if ($request->input('status') == 0) {
            $validatedData = $request->validate([
                'is_backdate' => 'required',
                'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                'unit_kerja' => 'required',
                'is_st_kinerja' => 'required',
                'st_kinerja_id' => $request->input('is_st_kinerja') === '1' ? 'required' : '',
                'melaksanakan' => 'required',
                'kota' => 'required',
                'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today',
                'selesai' => 'required|date|after_or_equal:mulai',
                'pelaksana' => 'required',
                'pembebanan_id' => 'required',
                'status' => 'required',
                'penandatangan' => 'required',
                'is_esign' => 'required'
            ],[
                'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
                'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
                'required' => 'Wajib diisi'
            ]);

            $validatedData['user_id'] = auth()->user()->id;
            $validatedData['pelaksana'] = implode(', ', $validatedData['pelaksana']);
            Stpd::where('id', $st_pd->id)->update($validatedData);

            return redirect('pegawai/st-pd')->with('success', 'Pengajuan kembali usulan ST Perjalanan Dinas berhasil!');
        } elseif ($request->input('status') == 3) {
            $validatedData = $request->validate([
                'status' => 'required',
                'file' => 'required|mimes:pdf'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => 'File yang diupload harus bertipe .pdf'
            ]);
            $no_surat = $st_pd->no_surat;
            if ($st_pd->file) {
                unlink(substr($st_pd->file, 1));
            }
            $validatedData['file'] = '/storage'.'/'.$request->file('file')->store('st-pd');
            Stpd::where('no_surat', $no_surat)->update($validatedData);
            return redirect('/pegawai/st-pd')->with('success', 'Berhasil mengunggah file!');
        } elseif ($request->input('status') == 6) {
            $validatedData = $request->validate([
                'status' => 'required',
                'laporan' => 'required|mimes:pdf'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => 'File yang diupload harus bertipe .pdf'
            ]);
            $no_surat = $st_pd->no_surat;
            if ($st_pd->laporan) {
                unlink(substr($st_pd->laporan, 1));
            }
            $validatedData['laporan'] = '/storage'.'/'.$request->file('laporan')->store('laporan');
            $validatedData['tanggal_laporan'] = date('Y-m-d');
            Stpd::where('no_surat', $no_surat)->update($validatedData);
            return redirect('/pegawai/st-pd')->with('success', 'Berhasil mengunggah laporan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stpd  $stpd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stpd $stpd)
    {
        //
    }
}
