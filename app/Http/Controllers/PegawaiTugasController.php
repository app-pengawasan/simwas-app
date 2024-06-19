<?php

namespace App\Http\Controllers;

use App\Models\AnggaranRencanaKerja;
use App\Models\MasterHasil;
use App\Models\ObjekPengawasan;
use App\Models\PelaksanaTugas;
use App\Models\Proyek;
use App\Models\RencanaKerja;
use App\Models\TimKerja;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiTugasController extends Controller
{
    protected $unsur = [
        'msu001'    => 'Perencanaan, pengorganisasian, dan pengendalian Pengawasan Intern',
        'msu002'    => 'Pelaksanaan teknis pengawasan internal',
        'msu003'    => 'Evaluasi Pengawasan Intern'
    ];

    protected $hasilKerja = [
        'mhk001' => 'Konsep rencana strategis pengawasan internal',
        'mhk002' => 'Konsep rencana pengawasan tahunan',
        'mhk003' => 'Laporan Hasil Pemantauan rencana pengawasan tahunan',
        'mhk004' => 'Peraturan/pedoman pengawasan intern',
        'mhk005' => 'Kebijakan pengawasan internal',
        'mhk006' => 'Laporan Hasil Audit Kinerja',
        'mhk007' => 'Laporan Hasil audit dengan tujuan tertentu',
        'mhk008' => 'Laporan Hasil Audit Investigatif/PKKN',
        'mhk009' => 'Laporan Hasil Reviu',
        'mhk010' => 'Laporan Hasil Evaluasi',
        'mhk011' => 'Laporan Hasil Pemantauan',
        'mhk012' => 'Laporan Pemberian Keterangan Ahli',
        'mhk013' => 'Hasil Telaah',
        'mhk014' => 'Laporan Hasil Monitoring Tindak Lanjut',
        'mhk015' => 'Laporan Kegiatan Sosialisasi',
        'mhk016' => 'Laporan Kegiatan bimbingan teknis',
        'mhk017' => 'Laporan Kegiatan asistensi',
        'mhk018' => 'Laporan Hasil Evaluasi',
        'mhk019' => 'Laporan Hasil Telaah Sejawat',
        'mhk020' => 'Laporan Penjaminan Kualitas',
        '2'      => 'Kertas Kerja'
    ];

    protected $pelaksanaTugas = [
        'ngt'   => 'Bukan Gugus Tugas',
        'gt'    => 'Gugus Tugas'
    ];

    protected $satuan = [
        's001'      => 'O-J',
        's002'      => 'O-P',
        's003'      => 'O-H',
        's004'      => 'PAKET'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rencanaKerja = RencanaKerja::with('pelaksana.user')->where('id_rencanakerja', $id)->get();
        $pegawai = User::all();
        $allHasilKerja = MasterHasil::where('kategori_pelaksana', 'ngt')->get();
        $masterHasilKerja = $this->hasilKerja;
        $timKerja = TimKerja::where('id_timkerja', $rencanaKerja[0]->id_timkerja)->first();
        $proyek = Proyek::where('id', $rencanaKerja[0]->id_proyek)->first();

        $ketuaTim = $timKerja->id_ketua;
        $userLogin = auth()->user()->id;
        if ($ketuaTim != $userLogin) {
            abort(403);
        }


        return view('pegawai.pelaksana-tugas.index', [
            'type_menu'         => 'rencana-kinerja',
            'rencanaKerja'      => $rencanaKerja[0],
            'unsur'             => $this->unsur,
            'pelaksanaTugas'    => $this->pelaksanaTugas,
            'satuan'            => $this->satuan,
            'pegawai'           => $pegawai,
            'allHasilKerja'     => $allHasilKerja,
            'masterHasilKerja'  => $masterHasilKerja,
            'timKerja'          => $timKerja,
            'proyek'            => $proyek,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
