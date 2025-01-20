<?php

namespace App\Http\Controllers;

use App\Models\Sl;
use App\Models\Surat;
use App\Models\Kka;
use Illuminate\Http\Request;
use App\Http\Controllers\SuratController;

class SlSekreController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('sekretaris');
        if (auth()->user()->is_sekma) {
            $usulan = Sl::latest()->get();
        } else {
            $usulan = Sl::latest()->where('unit_kerja', auth()->user()->unit_kerja)->get();
        }
        return view('sekretaris.usulan-surat.index', [
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
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function show(Sl $usulan_surat)
    {
        $this->authorize('sekretaris');
        return view('sekretaris.usulan-surat.show', [
            "usulan" => $usulan_surat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function edit(Sl $usulan_surat)
    {
        $this->authorize('sekretaris');
        $kka = Kka::all()->where('is_aktif', true);
        return view('sekretaris.usulan-surat.edit', [
            "kka" => $kka,
            "usulan" => $usulan_surat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sl $usulan_surat)
    {
        $this->authorize('sekretaris');
        if ($request->input('status') == '1' || $request->input('status') == '4') {
            $validatedData = $request->validate([
                'catatan' => 'required'
            ],[
                'required' => 'Wajib diisi'
            ]);
            $validatedData['status'] = $request->input('status');
            Sl::where('id', $request->input('id'))->update($validatedData);
            return redirect('sekretaris/usulan-surat')->with('success', 'Berhasil menolak usulan!');
        } elseif ($request->input('status') == '2') {
            if ($request->has('edit')) {
                $usulan = Sl::find($request->input('id'));
                $validatedData = $request->validate([
                    'is_backdate' => 'required',
                    'tanggal' => $request->input('is_backdate') === '1' ? 'required' : '',
                    'jenis_surat' => 'required',
                    'derajat_klasifikasi' => 'required',
                    'kka_id' => 'required',
                    'unit_kerja' => 'required',
                    'hal' => 'required',
                    'draft' => 'required|mimes:doc,docx',
                    'status' => 'required'
                ], [
                    'required' => 'Wajib diisi',
                    'mimes' => "File yang diupload harus bertipe .doc atau .docx"
                ]);
                $validatedData['draft'] = $request->file('draft')->store('draft');
                Sl::where('id', $request->input('id'))->update($validatedData);
            }
            $usulan = Sl::find($request->input('id'));
            $tanggal = ($usulan->is_backdate == '0') ? date('Y-m-d') : $usulan->tanggal;
            $data = new Request();
            $data->merge([
                'user_id' => $usulan->user_id,
                'derajat_klasifikasi' => $usulan->derajat_klasifikasi,
                'nomor_organisasi' => $usulan->unit_kerja,
                'kka' => $usulan->kka->kode,
                'tanggal' => $tanggal,
                'jenis' => $usulan->jenis_surat,
                'is_backdate' => $usulan->is_backdate
            ]);
            $buatSurat = new SuratController();
            $buatSurat->store($data);
            $nomorSurat = Surat::latest()->first()->nomor_surat;
            $validatedData = ([
                'status' => '2',
                'no_surat' => $nomorSurat,
                'tanggal' => $tanggal
            ]);
            Sl::where('id', $request->input('id'))->update($validatedData);
            return redirect('sekretaris/usulan-surat')->with('success', 'Berhasil menyetujui usulan nomor surat!');
        } elseif ($request->input('status') == '5') {
            $validatedData = $request->validate([
                'status' => 'required'
            ]);
            Sl::where('id', $request->input('id'))->update($validatedData);
            Surat::where('nomor_surat', $usulan_surat->no_surat)->update(['file' => $usulan_surat->surat]);
            return redirect('sekretaris/usulan-surat')->with('success', 'Berhasil menyetujui surat!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sl $sl)
    {
        //
    }
}
