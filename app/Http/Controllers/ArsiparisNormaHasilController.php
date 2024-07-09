<?php

namespace App\Http\Controllers;

use App\Models\StKinerja;
use App\Models\NormaHasil;
use Illuminate\Http\Request;
use App\Models\NormaHasilTim;
use App\Models\PelaksanaTugas;
use App\Models\NormaHasilAccepted;
use Illuminate\Database\Eloquent\Builder;

class ArsiparisNormaHasilController extends Controller
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

        $months=[
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $laporan = NormaHasilTim::latest()
                    ->whereRelation('normaHasilAccepted', function (Builder $query){
                        $query->whereNot('status_verifikasi_arsiparis', 'belum unggah');
                    })->orWhereRelation('normaHasilDokumen', function (Builder $query){
                        $query->whereNot('status_verifikasi_arsiparis', 'belum unggah');
                    })->get();

        return view('arsiparis.norma-hasil.index', [
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'type_menu' => 'tugas-tim',
            'laporan' => $laporan,
            'months' => $months
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
        $laporan = NormaHasilTim::findOrFail($request->norma_hasil);
        if ($request->jenis == 1) {
            $laporan->normaHasilAccepted->update([
                'status_verifikasi_arsiparis' => 'disetujui',
            ]);
        } else {
            $laporan->normaHasilDokumen->update([
                'status_verifikasi_arsiparis' => 'disetujui',
            ]);
        }
        return redirect()->back()->with('success', 'Norma Hasil Berhasil Disetujui');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $norma_hasil = NormaHasilTim::findOrFail($id);
        return view('arsiparis.norma-hasil.show', [
            "usulan" => $norma_hasil,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
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
        $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        return view('pegawai.norma-hasil.edit', [
            "usulan" => $norma_hasil,
            "stks" => $stks
        ]);
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
        $laporan = NormaHasilTim::findOrFail($id);

        if ($request->jenis == 1) {
            $laporan->normaHasilAccepted->update([
                'status_verifikasi_arsiparis' => 'ditolak',
                'catatan_arsiparis' => $request->alasan
            ]);
        } else {
            $laporan->normaHasilDokumen->update([
                'status_verifikasi_arsiparis' => 'ditolak',
                'catatan_arsiparis' => $request->alasan
            ]);
        }
        
        return redirect()->back()->with('success', 'Norma Hasil Berhasil Ditolak');
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
