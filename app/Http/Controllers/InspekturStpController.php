<?php

namespace App\Http\Controllers;

use App\Models\Stp;
use App\Models\Surat;
use App\Models\User;
use App\Models\Pp;
use App\Models\NamaPp;
use Illuminate\Http\Request;

class InspekturStpController extends Controller
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
        '8100' => 'Insapektorat Wilayah I',
        '8200' => 'Insapektorat Wilayah II',
        '8300' => 'Insapektorat Wilayah III'
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
        if ((auth()->user()->is_aktif) && (auth()->user()->unit_kerja == '8000') ) {
            $usulan = Stp::latest()->get();
        } else {
            $usulan = Stp::latest()->where('unit_kerja', auth()->user()->unit_kerja)->get();
        }
        return view('inspektur.st-pp.index', [
        ])->with('usulan', $usulan);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('inspektur.st-pp.show', [
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
        return view('inspektur.st-pp.edit', [
            "usulan" => $st_pp,
            "user" => $user,
            "pps" => $pps,
            "namaPps" => $namaPps
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stp  $stp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stp $st_pp)
    {
        if ($request->input('status') == '1') {
            $validatedData = $request->validate([
                'catatan' => 'required'
            ],[
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = '1';
            Stp::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-pp')->with('success', 'Berhasil menolak usulan surat!');
        } elseif ($request->input('status') == '2') {
            if ($request->has('edit')) {
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
                Stp::where('id', $request->input('id'))->update($validatedData);
            }
            $usulan = Stp::find($request->input('id'));
            $data = new Request();
            $tanggal = ($usulan->is_backdate == '0') ? date('Y-m-d') : $usulan->tanggal;
            $data->merge([
                'user_id' => $usulan->user_id,
                'derajat_klasifikasi' => 'B',
                'nomor_organisasi' => $usulan->unit_kerja,
                'kka' => 'KP.310',
                'tanggal' => $tanggal,
                'jenis' => 'ST Pengembangan Profesi',
                'is_backdate' => $usulan->is_backdate
            ]);
            $buatSurat = new SuratController();
            $buatSurat->store($data);
            $nomorSurat = Surat::latest()->first()->nomor_surat;
            
            $validatedData = ([
                'status' => '2',
                'tanggal' => $tanggal,
                'no_surat' => $nomorSurat
            ]);
            Stp::where('id', $request->input('id'))->update($validatedData);
            return redirect('inspektur/st-pp')->with('success', 'Berhasil menyetujui usulan surat!');
        }
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
}
