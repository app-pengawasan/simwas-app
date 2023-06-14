<?php

namespace App\Http\Controllers;

use App\Models\Stp;
use App\Models\User;
use App\Models\Pp;
use App\Models\NamaPp;
use App\Http\Requests\StoreStpRequest;
use App\Http\Requests\UpdateStpRequest;
use Illuminate\Http\Request;

class StpController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usulan = Stp::latest()->where('user_id', auth()->user()->id)->get();
        return view('pegawai.st-pp.index')->with('usulan', $usulan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pps = Pp::all()->where('is_aktif', true);
        $namaPps = NamaPp::all()->where('is_aktif', true);
        $user = User::all();
        return view('pegawai.st-pp.create', [
            "user" => $user,
            "pps" => $pps,
            "namaPps" => $namaPps
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStpRequest $request)
    {
        $validatedData = $request->validate([
            'is_backdate' => 'required',
            'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
            'unit_kerja' => 'required',
            'pp_id' => 'required',
            'nama_pp' => 'required',
            'melaksanakan' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'pegawai' => 'required',
            'penandatangan' => 'required',
            'is_esign' => 'required',
            'status' => 'required'
        ], [
            'required' => 'Wajib diisi'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['pegawai'] = implode(', ', $validatedData['pegawai']);
        Stp::create($validatedData);

        return redirect('pegawai/st-pp')->with('success', 'Berhasil mengajukan usulan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function show(Stp $st_pp)
    {
        $pegawaiArray = explode(', ', $st_pp->pegawai);
        $users = \App\Models\User::whereIn('id', $pegawaiArray)->get();
        $nama = $users->pluck('name')->toArray();
        $pegawai = implode(', ', $nama);
        return view('pegawai.st-pp.show', [
            "usulan" => $st_pp,
            "pegawai" => $pegawai
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function edit(Stp $st_pp)
    {
        $user = User::all();
        $pps = Pp::all()->where('is_aktif', true);
        $namaPps = NamaPp::all()->where('is_aktif', true);
        return view('pegawai.st-pp.edit', [
            "usulan" => $st_pp,
            "user" => $user,
            "pps" => $pps,
            "namaPps" => $namaPps
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStpRequest  $request
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStpRequest $request, Stp $st_pp)
    {
        $validatedData = $request->validate([
            'is_backdate' => 'required',
            'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
            'unit_kerja' => 'required',
            'pp_id' => 'required',
            'nama_pp' => 'required',
            'melaksanakan' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'pegawai' => 'required',
            'penandatangan' => 'required',
            'is_esign' => 'required',
            'status' => 'required'
        ], [
            'required' => 'Wajib diisi'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['pegawai'] = implode(', ', $validatedData['pegawai']);
        Stp::where('id', $st_pp->id)->update($validatedData);

        return redirect('pegawai/st-pp')->with('success', 'Pengajuan kembali usulan ST Pengembangan Profesi berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stp $stp)
    {
        //
    }

    public function getNamaPp(Request $request)
    {
        $namaPp = NamaPp::where('pp_id', $request->pp_id)->get();
        return response()->json(['namaPp' => $namaPp], 200);
    }

    
    // {{-- <input style="display: none;" type="text" class="form-control @error('nama_pp') is-invalid @enderror" id="nama_pp_text" name="nama_pp" value="{{ old('nama_pp') }}"> --}}
}
