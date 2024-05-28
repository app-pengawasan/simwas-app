<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\NormaHasilAccepted;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class TimNormaHasilController extends Controller
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
                    })->pluck('id_rencanakerja');
        $draf = NormaHasil::latest()->whereIn('tugas_id', $tugasSaya)
                ->where('status_norma_hasil', 'disetujui')
                ->whereRelation('normaHasilAccepted', function (Builder $query){
                    $query->where('status_verifikasi_arsiparis', 'belum unggah');
                })->get();
        $laporan = NormaHasilAccepted::latest()
                    ->whereRelation('normaHasil', function (Builder $query) use ($tugasSaya) {
                        $query->whereIn('tugas_id', $tugasSaya);
                    })->whereNot('status_verifikasi_arsiparis', 'belum unggah')
                      ->get();
        return view('pegawai.tugas-tim.norma-hasil.index', [
            'draf' => $draf,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'type_menu' => 'tugas-tim',
            'laporan' => $laporan
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
            'nomor' => ['required', 'string', 'max:26'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:1024'],
        ]; 

        $messages = [
            'required' => ':attribute harus diisi',
            'max' => 'Jumlah karakter maksimal 26',
            'file.max' => 'Ukuran file maksimal 1MB',
            'mimes' => 'Format file harus pdf'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        $file = $request->file('file');
        $fileName = time() . '-laporan-norma-hasil.' . $file->getClientOriginalExtension();
        $path = public_path('storage/tim/norma-hasil');
        $file->move($path, $fileName);
        $laporan_path = 'storage/tim/norma-hasil/' . $fileName;

        $norma_hasil_acc = NormaHasilAccepted::where('id_norma_hasil', $validateData['nomor'])->first();
        $norma_hasil_acc->update([
            'laporan_path' => $laporan_path,
            'status_verifikasi_arsiparis' => 'diperiksa'
        ]);

        // return back with success message
        return redirect()->back()->with('success', 'Laporan Norma Hasil Berhasil Diunggah');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show(NormaHasil $norma_hasil)
    {
        return view('pegawai.tugas-tim.norma-hasil.show', [
            "usulan" => $norma_hasil,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'type_menu' => 'tugas-tim'
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
    public function update(Request $request, $id)
    {
        $rules = [
            'nama' => ['required', 'file', 'mimes:pdf', 'max:1024'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $request->validate($rules);

        $laporan = NormaHasilAccepted::where('id_norma_hasil', $id)->first();
        $laporan_path_old = $laporan->laporan_path;
        File::delete(public_path().'/'.$laporan_path_old);

        $file = $request->file('nama');
        $fileName = time() . '-laporan-norma-hasil.' . $file->getClientOriginalExtension();
        $path = public_path('storage/tim/norma-hasil');
        $file->move($path, $fileName);
        $laporan_path = 'storage/tim/norma-hasil/' . $fileName;

        $laporan->update([
            'laporan_path' => $laporan_path,
            'status_verifikasi_arsiparis' => 'diperiksa',
            'catatan_arsiparis' => NULL
        ]);

        return redirect()->back()->with('success', 'Laporan Norma Hasil Berhasil Diedit');
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
