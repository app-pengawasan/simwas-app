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
    protected $pangkat = [
        'II/a' =>	'Pengatur Muda',
        'II/b' =>	'Pengatur Muda Tingkat I',
        'II/c' => 	'Pengatur',
        'II/d' => 	'Pengatur Tingkat I',
        'III/a' =>	'Penata Muda',
        'III/b' =>	'Penata Muda Tingkat I',
        'III/c' =>	'Penata',
        'III/d' =>	'Penata Tingkat I',
        'IV/a' =>	'Pembina',
        'IV/b' =>	'Pembina Tingkat I',
        'IV/c' =>	'Pembina Muda',
        'IV/d' =>	'Pembina Madya',
        'IV/e' =>	'Pembina Utama'
    ];

    protected $unit_kerja = [
        '8000' => 'Inspektorat Utama',
        '8010' => 'Bagian Umum Inspektorat Utama',
        '8100' => 'Inspektorat Wilayah I',
        '8200' => 'Inspektorat Wilayah II',
        '8300' => 'Inspektorat Wilayah III'
    ];

    protected $jabatan = [
        '21' =>	'Auditor Utama',
        '22' =>	'Auditor Madya',
        '23' =>	'Auditor Muda',
        '24' =>	'Auditor Pertama',
        '25' =>	'Auditor Penyelia',
        '26' =>	'Auditor Pelaksana Lanjutan',
        '27' =>	'Auditor Pelaksana',
        '31' =>	'Perencana Madya',
        '32' =>	'Perencana Muda',
        '33' =>	'Perencana Pertama',
        '41' =>	'Analis Kepegawaian Madya',
        '42' =>	'Analis Kepegawaian Muda',
        '43' =>	'Analis Kepegawaian Pertama',
        '51' =>	'Analis Pengelolaan Keuangan APBN Madya',
        '52' =>	'Analis Pengelolaan Keuangan APBN Muda',
        '53' =>	'Analis Pengelolaan Keuangan APBN Pertama',
        '61' =>	'Pranata Komputer Madya',
        '62' =>	'Pranata Komputer Muda',
        '63' =>	'Pranata Komputer Pratama',
        '71' =>	'Arsiparis Madya',
        '72' =>	'Arsiparis Muda',
        '73' =>	'Arsiparis Pertama',
        '81' =>	'Analis Hukum Madya',
        '82' =>	'Analis Hukum Muda',
        '83' =>	'Analis Hukum Pertama',
        '91' =>	'Penatalaksana Barang',
        '90' =>	'Fungsional Umum'
    ];

    protected $role = [
        'is_admin'      => 'Admin',
        'is_sekma'      => 'Sekretaris Utama',
        'is_sekwil'     => 'Sekretaris Wilayah',
        'is_perencana'  => 'Perencana',
        'is_apkapbn'    => 'APK-APBN',
        'is_opwil'      => 'Operator Wilayah',
        'is_analissdm'  => 'Analis SDM'
    ];

    protected $jabatan_pimpinan = [
        'jpm000'      => 'Inspektur Utama',
        'jpm001'      => 'Inspektur Wilayah I',
        'jpm002'      => 'Inspektur Wilayah II',
        'jpm003'      => 'Inspektur Wilayah III',
    ];
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
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "jabatan_pimpinan" => $this->jabatan_pimpinan
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
            'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today' ,
            'selesai' => 'required|date|after_or_equal:mulai',
            'is_gugus_tugas' => 'required',
            'is_perseorangan' => $request->input('is_gugus_tugas') === '0' ? 'required' : '',
            'dalnis_id' => $request->input('is_gugus_tugas') === '1' ? 'required' : '',
            'ketua_koor_id' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
            'anggota' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
            'penandatangan' => $request->input('is_esign') === '1' ? 'required' : '',
            'status' => 'required',
            'is_esign' => 'required',
        ],[
            'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
            'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
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
            "anggota" => $anggota,
            "jabatan_pimpinan" =>$this->jabatan_pimpinan
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
                'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today' ,
                'selesai' => 'required|date|after_or_equal:mulai',
                'is_gugus_tugas' => 'required',
                'is_perseorangan' => $request->input('is_gugus_tugas') === '0' ? 'required' : '',
                'dalnis_id' => $request->input('is_gugus_tugas') === '1' ? 'required' : '',
                'ketua_koor_id' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
                'anggota' => ($request->input('is_gugus_tugas') === '1' || $request->input('is_perseorangan') === '0') ? 'required' : '',
                'penandatangan' => $request->input('is_esign') === '1' ? 'required' : '',
                'status' => 'required',
                'is_esign' => 'required',
            ],[
                'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
                'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
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
            if ($st_kinerja->file) {
                unlink(substr($st_kinerja->file, 1));
            }
            $validatedData['file'] = '/storage'.'/'.$request->file('file')->store('st-kinerja');
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
