<?php

namespace App\Http\Controllers;

use App\Models\NormaHasil;
use App\Http\Requests\StoreNormaHasilRequest;
use App\Http\Requests\UpdateNormaHasilRequest;
use App\Models\ObjekNormaHasil;
use App\Models\StKinerja;
use Illuminate\Support\Facades\Storage;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;

class NormaHasilController extends Controller
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
        $year = $request->year;

        if ($year == null) {
            $year = date('Y');
        } else {
            $year = $year;
        }
        $currentYear = date('Y');

        $usulan = NormaHasil::with('normaHasilAccepted')
            ->where('user_id', auth()->user()->id)
            ->whereYear('created_at', $year)
            ->latest()
            ->get();
        // get year from created_at distinct
        $year = NormaHasil::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->get();

        $yearValues = $year->pluck('year')->toArray();

        if (!in_array($currentYear, $yearValues)) {
            // If the current year is not in the array, add it
            $year->push((object)['year' => $currentYear]);
            $yearValues[] = $currentYear; // Update the year values array
        }

        $year = $year->sortByDesc('year');

        return view('pegawai.norma-hasil.index', [
            'usulan' => $usulan,
            'kodeHasilPengawasan' => $this->kodeHasilPengawasan,
            'jenisNormaHasil' => $this->hasilPengawasan,
            'year' => $year
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rencanaKerja = RencanaKerja::latest()->whereHas('timkerja', function ($query) {
                            $query->whereIn('status', [1, 2]);
                        })->whereHas('pelaksana', function ($query) {
                            $query->where('id_pegawai', auth()->user()->id)
                                ->whereIn('pt_jabatan', [2, 3]);
                        })->get();
        // $stks = StKinerja::latest()->where('user_id', auth()->user()->id)->where('status', 5)->get();
        return view('pegawai.norma-hasil.create', [
            // "stks" => $stks
            'rencanaKerja' => $rencanaKerja,
            'hasilPengawasan' => $this->hasilPengawasan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNormaHasilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNormaHasilRequest $request)
    {
        $user_id = auth()->user()->id;
        $rencanaKerja = RencanaKerja::find($request->rencana_id);
        $unit_kerja = $rencanaKerja->timkerja->unitkerja;
        $tanggal = date('Y-m-d');

        try {
            NormaHasil::create([
                'user_id' => $user_id,
                'unit_kerja' => $unit_kerja,
                'tugas_id' => $request->rencana_id,
                'jenis_norma_hasil_id' => $request->jenis_norma_hasil,
                'document_path' => $request->url_norma_hasil,
                'nama_dokumen' => $request->nama_dokumen,
                'tanggal' => $tanggal,
                'status_norma_hasil' => 'diperiksa'
            ]);

            $norma_hasil_id = NormaHasil::latest()->first()->id;

            if ($request->objek_kegiatan != null) {
                foreach ($request->objek_kegiatan as $objek) {
                    ObjekNormaHasil::create([
                        'objek_id' => $objek,
                        'norma_hasil_id' => $norma_hasil_id
                    ]);
                }
            }
            return redirect('pegawai/norma-hasil')->with('success', 'Berhasil mengajukan usulan norma hasil!');
        } catch (\Exception $e) {
            return redirect('pegawai/norma-hasil')->with('error', 'Gagal mengajukan usulan norma hasil!');
        }

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function show(NormaHasil $norma_hasil)
    {
        $objek = ObjekNormaHasil::where('norma_hasil_id', $norma_hasil->id)->get();
        return view('pegawai.norma-hasil.show', [
            "usulan" => $norma_hasil,
            "objek" => $objek,
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
     * @param  \App\Http\Requests\UpdateNormaHasilRequest  $request
     * @param  \App\Models\NormaHasil  $normaHasil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNormaHasilRequest $request, NormaHasil $norma_hasil)
    {
        // dd($request->all());
        $norma_hasil->update([
            'status_norma_hasil' => 'ditolak',
            'catatan_norma_hasil' => $request->alasan
        ]);

        // return back with success message
        return redirect()->back()->with('success', 'Usulan Norma Hasil Berhasil Ditolak');


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
