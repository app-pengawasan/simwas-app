<?php

namespace App\Http\Controllers;

use App\Models\NormaHasilAccepted;
use App\Http\Requests\StoreNormaHasilAcceptedRequest;
use App\Http\Requests\UpdateNormaHasilAcceptedRequest;
use App\Models\NormaHasil;

class NormaHasilAcceptedController extends Controller
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

        // find normahasil where rencanakerja->timkerja where id_ketua is this auth
        $usulan = NormaHasil::latest()->whereHas('rencanaKerja.timkerja', function ($query) {
            $query->where('id_ketua', auth()->user()->id);
        })->get();



        return view('pegawai.usulan-norma-hasil.index', [
            'usulan' => $usulan,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'type_menu' => 'rencana-kinerja'
        ]);
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
     * @param  \App\Http\Requests\StoreNormaHasilAcceptedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNormaHasilAcceptedRequest $request)
    {
        // dd($request->all());
        // nomor norma hasil is increment from norma hasil accepted if its none then 1
        $nomor_norma_hasil = NormaHasilAccepted::latest()->first();
        if ($nomor_norma_hasil) {
            // if year in tanngal_norma_hasil is not same with now then reset nomor_norma_hasil to 1
            if (date('Y', strtotime($nomor_norma_hasil->tanggal_norma_hasil)) != date('Y')) {
                $nomor_norma_hasil = 1;
            } else {
                $nomor_norma_hasil = $nomor_norma_hasil->nomor_norma_hasil + 1;
            }
        } else {
            $nomor_norma_hasil = 1;
        }
        // dd($nomor_norma_hasil);
        $tanggal = date('Y-m-d');
        $norma_hasil = NormaHasil::find($request->norma_hasil);
        // dd($norma_hasil);
        NormaHasilAccepted::create([
            'id_norma_hasil' => $request->norma_hasil,
            'nomor_norma_hasil' => $nomor_norma_hasil,
            'kode_norma_hasil' => $norma_hasil->jenis_norma_hasil_id,
            'kode_klasifikasi_arsip' => "PW.120",
            'tanggal_norma_hasil' => $tanggal,
            'status_verifikasi_arsiparis' => 'diperiksa',
            'unit_kerja' => $norma_hasil->unit_kerja,
        ]);
        // update status norma hasil
        $norma_hasil->update([
            'status_norma_hasil' => 'disetujui'
        ]);

        // return back with success message
        return redirect()->back()->with('success', 'Usulan Norma Hasil Berhasil Disetujui');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasilAccepted  $normaHasilAccepted
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usulan = NormaHasil::find($id);
        return view('pegawai.usulan-norma-hasil.show', [
            'usulan' => $usulan,
            'type_menu' => 'rencana-kinerja',
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NormaHasilAccepted  $normaHasilAccepted
     * @return \Illuminate\Http\Response
     */
    public function edit(NormaHasilAccepted $normaHasilAccepted)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNormaHasilAcceptedRequest  $request
     * @param  \App\Models\NormaHasilAccepted  $normaHasilAccepted
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNormaHasilAcceptedRequest $request, NormaHasilAccepted $normaHasilAccepted)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NormaHasilAccepted  $normaHasilAccepted
     * @return \Illuminate\Http\Response
     */
    public function destroy(NormaHasilAccepted $normaHasilAccepted)
    {
        //
    }
}
