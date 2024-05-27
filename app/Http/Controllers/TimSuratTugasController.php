<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\NormaHasilAccepted;
use App\Models\SuratTugasTim;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class TimSuratTugasController extends Controller
{
    private $kodeHasilPengawasan = [
    "110" => 'LHA',
    "120" => 'LHK',
    "130" => 'LHT',
    "140" => 'LHI',
    "150" => 'LHR',
    "160" => 'LHE',
    "170" => 'LHP',
    "180" => 'LHN',
    "190" => 'LTA',
    "200" => 'LTR',
    "210" => 'LTE',
    "220" => 'LKP',
    "230" => 'LKS',
    "240" => 'LKB',
    "500" => 'EHP',
    "510" => 'LTS',
    "520" => 'PHP',
    "530" => 'QAP'
];
    private $hasilPengawasan = [
    "110" => "Laporan Hasil Audit Kepatuhan",
    "120" => "Laporan Hasil Audit Kinerja",
    "130" => "Laporan Hasil Audit ADTT",
    "140" => "Laporan Hasil Audit Investigasi",
    "150" => "Laporan Hasil Reviu",
    "160" => "Laporan Hasil Evaluasi",
    "170" => "Laporan Hasil Pemantauan",
    "180" => "Laporan Hasil Penelaahan",
    "190" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Audit",
    "200" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Reviu",
    "210" => "Laporan Hasil Monitoring Tindak Lanjut Hasil Evaluasi",
    "220" => "Laporan Pendampingan",
    "230" => "Laporan Sosialisasi",
    "240" => "Laporan Bimbingan Teknis",
    "500" => "Evaluasi Hasil Pengawasan",
    "510" => "Telaah Sejawat",
    "520" => "Pengolahan Hasil Pengawasan",
    "530" => "Penjaminan Kualitas Pengawasan"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_pegawai = auth()->user()->id;
        $tugasSaya = PelaksanaTugas::where('id_pegawai', $id_pegawai)
                    ->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query){
                        $query->where('status', 6);
                    })->get();
        $surat = SuratTugasTim::whereIn('tugas_id', $tugasSaya->pluck('id_rencanakerja'))
                ->get()->groupBy('nomor');
        return view('pegawai.tugas-tim.st.index', [
            // 'draf' => $draf,
            'type_menu' => 'tugas-tim',
            'tugasSaya' => $tugasSaya,
            'surat'     => $surat
            // 'laporan' => $laporan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'tugas' => ['required', 'array'],
            'tugas.*' => ['string', 'max:26'],
            'nomor_st' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:100'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:1024'],
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'max' => 'Jumlah karakter maksimal 100',
            'file.max' => 'Ukuran file maksimal 1MB',
            'mimes' => 'Format file harus pdf'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $file = $request->file('file');
        $fileName = time() . '-surat-tugas.' . $file->getClientOriginalExtension();
        $path = public_path('storage/tim/st');
        $file->move($path, $fileName);
        $path = 'storage/tim/st/' . $fileName;

        foreach ($validateData['tugas'] as $tugas) {
            SuratTugasTim::create([
                'nomor' => $validateData['nomor_st'],
                'tugas_id' => $tugas,
                'nama' => $validateData['nama'],
                'path' => $path,
                'status' => 'diperiksa',
            ]);
        }

        // return back with success message
        return redirect()->back()->with('success', 'Surat Tugas Berhasil Diunggah');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nomor)
    {
        $surat = SuratTugasTim::where('nomor', $nomor)->get();
        $tugas = $surat->pluck('rencanaKerja.tugas');

        return view('pegawai.tugas-tim.st.show', [
            'type_menu' => 'tugas-tim',
            'surat'     => $surat->first(),
            'tugas'     => $tugas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(NormaHasil $norma_hasil)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nomor)
    {
        $rules = [
            'file' => ['required', 'file', 'mimes:pdf', 'max:1024'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->validate($rules);

        $surat = SuratTugasTim::where('nomor', $nomor);
        $path_old = $surat->get()->first()->path;
        File::delete(public_path().'/'.$path_old);

        $file = $request->file('file'); 
        $fileName = time() . '-surat-tugas.' . $file->getClientOriginalExtension();
        $path = public_path('storage/tim/st');
        $file->move($path, $fileName);
        $path_new = 'storage/tim/st/' . $fileName;

        $surat->update([
            'path' => $path_new,
            'status' => 'diperiksa',
            'catatan' => NULL
        ]);

        return redirect()->back()->with('success', 'Surat Tugas Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(NormaHasil $normaHasil)
    {
        //
    }
}
