<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\User;
use App\Http\Requests\StoreStKinerjaRequest;
use App\Http\Requests\UpdateStKinerjaRequest;
use App\Models\MasterPimpinan;
use App\Models\ObjekPengawasan;
use App\Models\PelaksanaTugas;
use App\Models\RencanaKerja;
use Illuminate\Support\Facades\Auth;
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
        '0'  => '-',
        '10' => 'Inspektur Utama',
        '11' => 'Inspektur Wilayah I',
        '12' => 'Inspektur wilayah II',
        '13' => 'Inspektur wilayah III',
        '14' => 'Kepala Bagian Umum',
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
        'jpm004'      => 'Kepala Bagian Umum'
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
        $rencana_kerja = RencanaKerja::latest()->whereHas('pelaksana', function ($query) {
                            $query->where('id_pegawai', auth()->user()->id)
                                ->whereIn('pt_jabatan', [2, 3]);
                        })->get();
        $objPengawasan = ObjekPengawasan::all();
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        return view('pegawai.st-kinerja.create', [
            "rencana_kerja" => $rencana_kerja,
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "jabatan_pimpinan" => $this->jabatan_pimpinan,
            "objPengawasan" => $objPengawasan
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
            'rencana_id' => 'required',
            'melaksanakan' => 'required',
            'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today' ,
            'selesai' => 'required|date|after_or_equal:mulai',
            'penandatangan' => 'required',
            'status' => 'required',
            'is_esign' => 'required',
        ],[
            'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
            'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
            'required' => 'Wajib diisi.'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
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
        $rencana_kerja = RencanaKerja::latest()->whereHas('pelaksana', function ($query) {
            $query->where('id_pegawai', auth()->user()->id)
                ->whereIn('pt_jabatan', [2, 3]);
        })->get();
        $objPengawasan = ObjekPengawasan::all();
        $pimpinanAktif = MasterPimpinan::latest()->whereDate('selesai', '>=', date('Y-m-d'))->get();
        $pimpinanNonaktif = MasterPimpinan::latest()->whereDate('selesai', '<', date('Y-m-d'))->get();
        $user = User::all();
        return view('pegawai.st-kinerja.edit', [
            "usulan" => $st_kinerja,
            "rencana_kerja" => $rencana_kerja,
            "user" => $user,
            "pimpinanAktif" => $pimpinanAktif,
            "pimpinanNonaktif" => $pimpinanNonaktif,
            "jabatan_pimpinan" => $this->jabatan_pimpinan,
            "objPengawasan" => $objPengawasan
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
                'rencana_id' => 'required',
                'melaksanakan' => 'required',
                'mulai' => $request->input('is_backdate') === '1' ? 'required|date|after_or_equal:tanggal' : 'required|date|after_or_equal:today' ,
                'selesai' => 'required|date|after_or_equal:mulai',
                'penandatangan' => 'required',
                'status' => 'required',
                'is_esign' => 'required',
            ],[
                'selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan waktu mulai.',
                'mulai.after_or_equal' => 'Tanggal mulai harus setelah atau sama dengan hari ini/tanggal surat',
                'required' => 'Wajib diisi.'
            ]);

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
