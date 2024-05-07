<?php

namespace App\Http\Controllers;

use App\Models\NormaHasilAccepted;
use App\Http\Requests\StoreNormaHasilAcceptedRequest;
use App\Http\Requests\UpdateNormaHasilAcceptedRequest;
use App\Models\NormaHasil;
use App\Models\ObjekNormaHasil;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {

        $year = request()->year;
        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        // find normahasil where rencanakerja->timkerja where id_ketua is this auth
        $usulan = NormaHasil::with('user', 'normaHasilAccepted')->latest()->whereYear('created_at', $year)->whereHas('rencanaKerja.timkerja', function ($query) {
            $query->where('id_ketua', auth()->user()->id);
        })->get();
        $year = NormaHasil::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->get();

        $currentYear = date('Y');


        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');

        return view('pegawai.usulan-norma-hasil.index', [
            'usulan' => $usulan,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'jenisNormaHasil' => $this->hasilPengawasan,
            'type_menu' => 'rencana-kinerja',
            'year' => $year,
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

        $tanggal = date('Y-m-d');
        $norma_hasil = NormaHasil::find($request->norma_hasil);
        $nomor_norma_hasil = NormaHasilAccepted::where('kode_norma_hasil', $norma_hasil->jenis_norma_hasil_id)->latest()->first();
        if ($nomor_norma_hasil) {
            if (date('Y', strtotime($nomor_norma_hasil->tanggal_norma_hasil)) != date('Y')) {
                $nomor_norma_hasil = 1;
            } else {
                $nomor_norma_hasil = $nomor_norma_hasil->nomor_norma_hasil + 1;
            }
        } else {
            $nomor_norma_hasil = 1;
        }

        NormaHasilAccepted::create([
            'id_norma_hasil' => $request->norma_hasil,
            'nomor_norma_hasil' => $nomor_norma_hasil,
            'kode_norma_hasil' => $norma_hasil->jenis_norma_hasil_id,
            'kode_klasifikasi_arsip' => "PW.120",
            'tanggal_norma_hasil' => $tanggal,
            'status_verifikasi_arsiparis' => 'belum unggah',
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
        $objek = ObjekNormaHasil::where('norma_hasil_id', $id)->get();

        return view('pegawai.usulan-norma-hasil.show', [
            'usulan' => $usulan,
            'objek' => $objek,
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
