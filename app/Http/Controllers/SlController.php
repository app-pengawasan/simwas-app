<?php

namespace App\Http\Controllers;

use App\Models\Sl;
use App\Models\Kka;
use App\Http\Requests\StoreSlRequest;
use App\Http\Requests\UpdateSlRequest;
use Illuminate\Support\Facades\Storage;

class SlController extends Controller
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
        $usulan = Sl::latest()->where('user_id', auth()->user()->id)->get();
        return view('pegawai.surat-lain.index')->with('usulan', $usulan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kka = Kka::all()->where('is_aktif', true);
        return view('pegawai.surat-lain.create', [
            "type_menu" => "surat-saya",
            "kka" => $kka
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlRequest $request)
    {
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

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['draft'] = $request->file('draft')->store('draft');
        Sl::create($validatedData);

        return redirect('pegawai/surat-lain')->with('success', 'Berhasil mengajukan usulan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function show(Sl $surat_lain)
    {
        return view('pegawai.surat-lain.show', [
            "title" => "Detail Usulan Surat Lain",
            "type_menu" => "surat-saya",
            "usulan" => $surat_lain
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function edit(Sl $surat_lain)
    {
        $kka = Kka::all()->where('is_aktif', true);
        return view('pegawai.surat-lain.edit', [
            "kka" => $kka,
            "usulan" => $surat_lain
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSlRequest  $request
     * @param  \App\Models\Sl  $sl
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlRequest $request, Sl $surat_lain)
    {
        if ($request->input('status') == '0') {
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
            Sl::where('id', $surat_lain->id)->update($validatedData);
    
            return redirect('pegawai/surat-lain')->with('success', 'Berhasil mengajukan kembali usulan surat!');
        } elseif ($request->input('status') == '3') {
            $validatedData = $request->validate([
                'status' => 'required',
                'id' => 'required',
                'surat' => 'required|mimes:pdf'
            ], [
                'required' => 'Wajib diisi',
                'mimes' => 'File yang diupload harus bertipe .pdf'
            ]);
            if ($surat_lain->surat) {
                Storage::delete($surat_lain->surat);
            }
            $validatedData['surat'] = '/storage'.'/'.$request->file('surat')->store('surat-lain');
            Sl::where('id', $request->input('id'))->update($validatedData);
            return redirect('/pegawai/surat-lain')->with('success', 'Berhasil mengunggah file!');
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

    public function upload()
    {
        return view('pegawai.surat-lain.upload', [
            "title" => "Upload Surat",
            "type_menu" => "surat-saya"
        ]);
    }

    // public function uploadFile(UpdateSlRequest $request)
    // {
    //     $no_surat = $request->no_surat;
    //     $file_name = $request->file('fileToUpload')->store('surat-lain-update');
    //     Sl::where('no_surat', $no_surat)->update(['surat' => $file_name, 'status' => '3']);
    //     return redirect('/pegawai/surat-lain')->with('success', 'Berhasil mengunggah file!');
    // }

    // public function suratUpdate(UpdateSlRequest $request)
    // {
    //     $no_surat = $request->no_surat;
    //     $file_name = $request->file('fileToUpload')->store('surat-lain-update');
    //     Sl::where('no_surat', $no_surat)->update(['surat' => $file_name, 'status' => '3']);
    //     return redirect('/pegawai/surat-lain');
    // }
}
