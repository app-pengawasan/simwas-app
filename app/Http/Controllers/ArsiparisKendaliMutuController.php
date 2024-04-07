<?php

namespace App\Http\Controllers;

use App\Models\KendaliMutuTim;
use App\Models\StKinerja;
use App\Models\SuratTugasTim;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\PelaksanaTugas;
use App\Models\NormaHasilAccepted;
use Illuminate\Database\Eloquent\Builder;

class ArsiparisKendaliMutuController extends Controller
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
        $this->authorize('arsiparis');
        $dokumen = KendaliMutuTim::latest()->get();
        return view('arsiparis.km.index', [
            'dokumen' => $dokumen
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
        $km = KendaliMutuTim::findOrFail($request->kendali_mutu);
        $km->update([
            'status' => 'disetujui',
        ]);
        return redirect()->back()->with('success', 'Kendali Mutu Berhasil Disetujui');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratTugasTim  $suratTugas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $surat = KendaliMutuTim::findOrFail($id); 
        return view('arsiparis.km.show', [
            "surat" => $surat,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratTugasTim  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(NormaHasil $norma_hasil)
    {
        // $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        // return view('pegawai.norma-hasil.edit', [
        //     "usulan" => $norma_hasil,
        //     "stks" => $stks
        // ]);
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
        $km = KendaliMutuTim::findOrFail($id);
        $km->update([
            'status' => 'ditolak',
            'catatan' => $request->alasan
        ]);

        $request->session()->put('status', 'Kendali Mutu Berhasil Ditolak');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratTugasTim  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratTugasTim $normaHasil)
    {
        //
    }
}
